<?php

declare(strict_types=1);

namespace Devjs\EloquentResources\Http\Validations\Traits;

use Closure as BaseClosure;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\Validator;
use Illuminate\Validation\Factory;
use Illuminate\Contracts\Auth\Access\Gate;
use Illuminate\Validation\ValidationException;

/* partly copy/paste from lumen's ProvidesConvenienceMethods trait */

trait ValidateMethodTrait
{
    protected static $responseBuilder;
    protected static $errorFormatter;

    public static function buildResponseUsing(BaseClosure $callback): void
    {
        static::$responseBuilder = $callback;
    }

    public static function formatErrorsUsing(BaseClosure $callback): void
    {
        static::$errorFormatter = $callback;
    }

    public function validate(Request $request, array $rules, array $messages = [], array $customAttributes = []): void
    {
        $validator = $this->getValidationFactory()->make($request->all(), $rules, $messages, $customAttributes);

        if ($validator->fails()) {
            $this->throwValidationException($request, $validator);
        }
    }

    protected function throwValidationException(Request $request, $validator): void
    {
        throw new ValidationException($validator, $this->buildFailedValidationResponse(
            $request, $this->formatValidationErrors($validator)
        ));
    }

    protected function buildFailedValidationResponse(Request $request, array $errors): JsonResponse
    {
        if (isset(static::$responseBuilder)) {
            return call_user_func(static::$responseBuilder, $request, $errors);
        }

        return new JsonResponse($errors, 422);
    }

    protected function formatValidationErrors(Validator $validator): array
    {
        if (isset(static::$errorFormatter)) {
            return call_user_func(static::$errorFormatter, $validator);
        }

        return $validator->errors()->getMessages();
    }

    protected function getValidationFactory(): Factory
    {
        return app('validator');
    }
}

<?php


if (!function_exists('formatErrorValidation')) {
    function formatErrorValidatioon($errors)
    {
        $formattedErrors = [];
        foreach ($errors->toArray() as $field => $messages) {
            foreach ($messages as $message) {
                $formattedErrors[] = [
                    'param' => $field,
                    'message' => $message
                ];
            }
        }
        return $formattedErrors;
    }
}

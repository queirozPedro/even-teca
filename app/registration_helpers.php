<?php

if (!function_exists('registrationStatusPt')) {
    /**
     * Map English registration status to Portuguese label.
     */
    function registrationStatusPt($status)
    {
        return match ($status) {
            'pending' => 'Pendente',
            'completed' => 'Confirmado',
            'canceled' => 'Cancelado',
            // fallback for legacy or unexpected values
            'pendente' => 'Pendente',
            'confirmado' => 'Confirmado',
            'cancelado' => 'Cancelado',
            default => ucfirst($status),
        };
    }
}

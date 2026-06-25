<?php

namespace App\Services;

use App\Models\Property;
use App\Models\SalesPerson;
use Illuminate\Support\Facades\Http;

class WhatsAppService
{
    private string $authKey = 'PARESHPROPERTIES';
    private string $instanceId = '624537';
    private string $baseUrl = 'https://wywspl.com/sendMessage.php';

    public function sendPropertyAssignedToCustomer(Property $property, string $customerName, string $customerPhone, $salesPersons = null): void
    {
        $salesPersons ??= $property->salesPersons;

        if ($salesPersons->isEmpty()) return;

        $message = $this->buildMessage($property, $customerName, $customerPhone);

        foreach ($salesPersons as $sp) {
            if ($sp->phone) {
                $personalMsg = "Dear " . $sp->name . ",\n\n" . $message;
                $this->send($sp->phone, $personalMsg);
            }
        }
    }

    public function sendPropertyDetails(Property $property, $salesPersons = null): void
    {
        $salesPersons ??= $property->salesPersons;

        if ($salesPersons->isEmpty()) return;

        $message = $this->buildPropertyMessage($property);

        foreach ($salesPersons as $sp) {
            if ($sp->phone) {
                $personalMsg = "Dear " . $sp->name . ",\n\n" . $message;
                $this->send($sp->phone, $personalMsg);
            }
        }
    }

    private function buildPropertyMessage(Property $property): string
    {
        $size = '';
        if ($property->length && $property->width) {
            $size = $property->length . ' ' . ($property->size_separator ?? 'X') . ' ' . $property->width . ' ' . ($property->area_unit ?? 'Sq.ft');
        } elseif ($property->area_size) {
            $size = $property->area_size . ' ' . ($property->area_unit ?? 'Sq.ft');
        }

        $lines = [
            "Property Details",
            "",
            "Title: " . ($property->title ?? '-'),
            "Size: " . ($size ?: '-'),
            "Type: " . ($property->property_type ?? '-'),
            "Rate (Sq.Yard): " . ($property->sq_yard_rate ? '₹ ' . number_format($property->sq_yard_rate, 2) : '-'),
            "Total Amount: " . ($property->price ? '₹ ' . number_format($property->price, 2) : '-'),

        ];

        return implode("\n", $lines);
    }

    private function buildMessage(Property $property, string $customerName, string $customerPhone): string
    {
        $message = $this->buildPropertyMessage($property);

        return $message . "\n\nCustomer Name: " . $customerName . "\nCustomer Phone: " . $customerPhone;
    }

    public function sendMessage(string $phone, string $message): bool
    {
        try {
            $this->send($phone, $message);
            return true;
        } catch (\Exception $e) {
            logger('WhatsApp sendMessage failed: ' . $e->getMessage());
            return false;
        }
    }

    private function send(string $phone, string $message): void
    {
        try {
            $url = $this->baseUrl
                . '?AUTH_KEY=' . urlencode($this->authKey)
                . '&instance_id=' . urlencode($this->instanceId)
                . '&message=' . urlencode($message)
                . '&phone=' . urlencode($phone);

            Http::timeout(15)->get($url);
        } catch (\Exception $e) {
            logger('WhatsApp send failed: ' . $e->getMessage());
        }
    }
}

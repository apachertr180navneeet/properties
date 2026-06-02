<?php

namespace App\Services;

use App\Models\Property;
use App\Models\SalesPerson;
use Illuminate\Support\Facades\Http;

class WhatsAppService
{
    private string $authKey = 'NAVNEETGSG';
    private string $instanceId = '468753';
    private string $baseUrl = 'https://wywspl.com/sendMessage.php';

    public function sendPropertyAssignedToCustomer(Property $property, string $customerName): void
    {
        $salesPersons = $property->salesPersons;

        if ($salesPersons->isEmpty()) return;

        $message = $this->buildMessage($property, $customerName);

        foreach ($salesPersons as $sp) {
            if ($sp->phone) {
                $this->send($sp->phone, $message);
            }
        }
    }

    public function sendPropertyDetails(Property $property): void
    {
        $salesPersons = $property->salesPersons;

        if ($salesPersons->isEmpty()) return;

        $message = $this->buildPropertyMessage($property);

        foreach ($salesPersons as $sp) {
            if ($sp->phone) {
                $this->send($sp->phone, $message);
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
            "Owner: " . ($property->owner_name ?? '-'),
            "Owner Phone: " . ($property->owner_phone ?? '-'),
        ];

        return implode("\n", $lines);
    }

    private function buildMessage(Property $property, string $customerName): string
    {
        $message = $this->buildPropertyMessage($property);

        return $message . "\n\nCustomer: " . $customerName;
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

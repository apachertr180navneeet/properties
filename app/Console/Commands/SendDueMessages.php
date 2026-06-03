<?php

namespace App\Console\Commands;

use App\Models\Customer;
use App\Models\MessageTemplate;
use App\Services\WhatsAppService;
use Illuminate\Console\Command;

class SendDueMessages extends Command
{
    protected $signature = 'whatsapp:send-due-messages';
    protected $description = 'Send due WhatsApp messages to customers based on message templates';

    public function handle(WhatsAppService $whatsApp): void
    {
        $today = now()->startOfDay();

        $customers = Customer::where('messaging', 'start')
            ->whereNotNull('phone')
            ->whereNotNull('messaging_started_at')
            ->whereDate('messaging_started_at', '<', $today)
            ->get();

        if ($customers->isEmpty()) {
            $this->info('No customers with active messaging found.');
            return;
        }

        $sent = 0;

        foreach ($customers as $customer) {
            $dayNumber = now()->startOfDay()->diffInDays($customer->messaging_started_at->startOfDay()) + 1;

            $templates = MessageTemplate::where('days_to_send', $dayNumber)
                ->where('status', 'active')
                ->get();

            if ($templates->isEmpty()) {
                continue;
            }

            foreach ($templates as $template) {
                $success = $whatsApp->sendMessage($customer->phone, $template->message_content);
                if ($success) {
                    $customer->increment('whatsapp_count');
                    $sent++;
                    $this->info("Sent template '{$template->template_name}' (Day {$dayNumber}) to {$customer->name} ({$customer->phone})");
                } else {
                    $this->error("Failed to send template '{$template->template_name}' to {$customer->name} ({$customer->phone})");
                }
            }
        }

        $this->info("Completed. Sent {$sent} message(s).");
    }
}

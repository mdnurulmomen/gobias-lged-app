<?php

namespace App\Services;

use App\Traits\ApiHeart;
use App\Traits\UserInfoCollector;

class FireNotificationServices
{
    use ApiHeart, UserInfoCollector;

    public function sendMailToRpu($required_data)
    {
        try {
            $meta_data = [];
            if (\Arr::has($required_data, 'cost_center_id')) {
                $meta_data['cost_center_id'] = $required_data['cost_center_id'];
            }
            if (\Arr::has($required_data, 'entity_id')) {
                $meta_data['entity_id'] = $required_data['entity_id'];
            }
            $data = [
                'notifiable_application' => 'rpu',
                'notifiable_type' => $required_data['notifiable_type'],
                'meta_data' => json_encode($meta_data),
            ];
            if (!empty($meta_data)) {
                $mail_data = [
                    'subject' => 'You Have Received Audit Query',
                ];
                $content = view('email.query_email_template', compact('mail_data'))->render();
                $data['mail_subject'] = 'You Have Received Audit Query';
                $data['mail_body'] = $content;
                $send_mail = $this->initHttpWithToken()->post(config('amms_bee_routes.notification.send-mail'), $data)->json();
                if (isSuccess($send_mail, 'status', 'error')) {
                    throw new \Exception($send_mail['message']);
                }
                return response()->json(responseFormat('success', 'Successfully Sent Mail'));
            }
        } catch (\Exception $exception) {
            \Log::error($exception->getMessage());
            return response()->json(responseFormat('error', $exception->getMessage()));
        }
    }

}

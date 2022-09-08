<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class OrderCheckResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'order_id' => $this->order_id,
            'number' => $this->phone_number,
            'service_name' => $this->service->service_name,
            'status' => $this->status,
            'sms_message' => $this->present_sms_message //showing the present sms message
        ];
    }
}

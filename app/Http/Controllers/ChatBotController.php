<?php

namespace App\Http\Controllers;

use App\Models\BotQA;
use Illuminate\Http\Request;

class ChatBotController extends Controller
{
    public function reply(Request $request)
    {
        $input = strtolower($request->input('message'));

        $matched = BotQA::all()->first(function ($item) use ($input) {
            $keywords = explode(',', strtolower($item->keywords));
            foreach ($keywords as $kw) {
                if (str_contains($input, trim($kw))) return true;
            }
            return false;
        });

        if ($matched) {
            return response()->json(['answer' => $matched->answer]);
        }

        return response()->json(['answer' => 'Xin lỗi, tôi chưa hiểu câu hỏi của bạn.']);
    }
}

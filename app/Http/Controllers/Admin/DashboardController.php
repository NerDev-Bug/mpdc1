<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\News;
use App\Models\Booking;
use App\Models\Contacts;
use App\Models\Inquiry;
use App\Models\Inquiry1;
use Inertia\Inertia;

class DashboardController extends Controller
{
    public function index()
    {
        return Inertia::render('admin/Dashboard', [
            'stats' => [
                'total_news' => News::count(),
                'active_news' => News::where('is_active', true)->count(),
                'total_bookings' => Booking::count(),
                'total_contacts' => Contacts::count(),
                'total_inquiries' => Inquiry::count() + Inquiry1::count(),
            ],
        ]);
    }
}

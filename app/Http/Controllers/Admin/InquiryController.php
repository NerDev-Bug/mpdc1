<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Inquiry;
use App\Models\Inquiry1;
use App\Models\Contacts;
use App\Models\Booking;
use Illuminate\Http\Request;
use Inertia\Inertia;

class InquiryController extends Controller
{
    public function index(Request $request)
    {
        $tab = $request->get('tab', 'service');

        // Service Residence Inquiries
        $serviceInquiries = Inquiry::orderByDesc('created_at')->get();

        // Private Residence Inquiries
        $privateInquiries = Inquiry1::orderByDesc('created_at')->get();

        // Contact Us Submissions
        $contactSubmissions = Contacts::orderByDesc('created_at')->get();

        // Booking / Partner Requests
        $bookingRequests = Booking::orderByDesc('created_at')->get();

        return Inertia::render('admin/InquiryIndex', [
            'serviceInquiries' => $serviceInquiries,
            'privateInquiries' => $privateInquiries,
            'contactSubmissions' => $contactSubmissions,
            'bookingRequests' => $bookingRequests,
            'activeTab' => $tab,
        ]);
    }

    public function destroyService(Inquiry $inquiry)
    {
        $inquiry->delete();
        return redirect()->route('admin.inquiries.index', ['tab' => 'service'])->with('success', 'Inquiry deleted.');
    }

    public function destroyPrivate(Inquiry1 $inquiry1)
    {
        $inquiry1->delete();
        return redirect()->route('admin.inquiries.index', ['tab' => 'private'])->with('success', 'Inquiry deleted.');
    }

    public function destroyContact(Contacts $contact)
    {
        $contact->delete();
        return redirect()->route('admin.inquiries.index', ['tab' => 'contacts'])->with('success', 'Contact submission deleted.');
    }

    public function destroyBooking(Booking $booking)
    {
        $booking->delete();
        return redirect()->route('admin.inquiries.index', ['tab' => 'bookings'])->with('success', 'Booking request deleted.');
    }
}

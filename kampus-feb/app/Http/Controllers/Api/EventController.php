<?php
// app/Http/Controllers/Api/EventController.php (atau sesuai lokasi Anda)

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Event;
use Illuminate\Http\Request;

class EventController extends Controller
{
    public function getByDate(Request $request)
    {
        try {
            $date = $request->input('date', now()->format('Y-m-d'));
            
            // PASTIKAN query ini SAMA dengan yang digunakan saat page load
            $events = Event::where('status', 'published') // Tambahkan filter yang sama
                ->whereDate('start_date', $date)
                ->orderBy('start_time', 'asc')
                ->get();
            
            // Jika tidak ada events, return empty state
            if ($events->isEmpty()) {
                return response()->json([
                    'success' => false,
                    'html' => $this->getEmptyStateHtml(),
                    'count' => 0
                ]);
            }
            
            $html = view('frontend.home.partials.events-list', compact('events'))->render();
            
            return response()->json([
                'success' => true,
                'html' => $html,
                'count' => $events->count()
            ]);
            
        } catch (\Exception $e) {
            \Log::error('Error fetching events by date: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan saat memuat event',
                'error' => $e->getMessage()
            ], 500);
        }
    }
    
    /**
     * Get empty state HTML
     */
    private function getEmptyStateHtml()
    {
        return '
            <div class="p-12 text-center">
                <div class="w-20 h-20 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                    <i class="fas fa-calendar-times text-3xl text-gray-400"></i>
                </div>
                <h3 class="text-xl font-bold text-gray-800 mb-2">Tidak Ada Event</h3>
                <p class="text-gray-600">Tidak ada event pada tanggal ini</p>
            </div>
        ';
    }
}
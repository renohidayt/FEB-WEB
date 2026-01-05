@if(session('success'))
<div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-4 rounded shadow-sm" role="alert">
    <div class="flex items-start">
        <i class="fas fa-check-circle mt-0.5 mr-3 text-lg"></i>
        <div>
            <p class="font-bold">Sukses!</p>
            <p class="text-sm">{{ session('success') }}</p>
        </div>
    </div>
</div>
@endif

@if(session('error'))
<div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-4 rounded shadow-sm" role="alert">
    <div class="flex items-start">
        <i class="fas fa-exclamation-circle mt-0.5 mr-3 text-lg"></i>
        <div>
            <p class="font-bold">Error!</p>
            <p class="text-sm">{{ session('error') }}</p>
        </div>
    </div>
</div>
@endif

@if(session('warning'))
<div class="bg-yellow-100 border-l-4 border-yellow-500 text-yellow-700 p-4 mb-4 rounded shadow-sm" role="alert">
    <div class="flex items-start">
        <i class="fas fa-exclamation-triangle mt-0.5 mr-3 text-lg"></i>
        <div>
            <p class="font-bold">Peringatan!</p>
            <p class="text-sm">{{ session('warning') }}</p>
        </div>
    </div>
</div>
@endif

@if(session('info'))
<div class="bg-blue-100 border-l-4 border-blue-500 text-blue-700 p-4 mb-4 rounded shadow-sm" role="alert">
    <div class="flex items-start">
        <i class="fas fa-info-circle mt-0.5 mr-3 text-lg"></i>
        <div>
            <p class="font-bold">Info!</p>
            <p class="text-sm">{{ session('info') }}</p>
        </div>
    </div>
</div>
@endif
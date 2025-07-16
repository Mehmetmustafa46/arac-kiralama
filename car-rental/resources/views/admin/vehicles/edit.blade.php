<x-admin-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h1 class="text-2xl font-semibold mb-6">Araç Düzenle</h1>

                    <form method="POST" action="{{ route('admin.vehicles.update', $vehicle) }}">
                        @csrf
                        @method('PUT')

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div class="mb-4">
                                <label for="brand" class="block text-sm font-medium text-gray-700 mb-1">Marka</label>
                                <input type="text" class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 @error('brand') border-red-500 @enderror" id="brand" name="brand" value="{{ old('brand', $vehicle->brand) }}" required>
                                @error('brand')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="mb-4">
                                <label for="model" class="block text-sm font-medium text-gray-700 mb-1">Model</label>
                                <input type="text" class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 @error('model') border-red-500 @enderror" id="model" name="model" value="{{ old('model', $vehicle->model) }}" required>
                                @error('model')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="mb-4">
                                <label for="year" class="block text-sm font-medium text-gray-700 mb-1">Yıl</label>
                                <input type="number" class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 @error('year') border-red-500 @enderror" id="year" name="year" value="{{ old('year', $vehicle->year) }}" required>
                                @error('year')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="mb-4">
                                <label for="plate_number" class="block text-sm font-medium text-gray-700 mb-1">Plaka</label>
                                <input type="text" class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 @error('plate_number') border-red-500 @enderror" id="plate_number" name="plate_number" value="{{ old('plate_number', $vehicle->plate_number) }}" required>
                                @error('plate_number')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="mb-4">
                                <label for="color" class="block text-sm font-medium text-gray-700 mb-1">Renk</label>
                                <input type="text" class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 @error('color') border-red-500 @enderror" id="color" name="color" value="{{ old('color', $vehicle->color) }}" required>
                                @error('color')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="mb-4">
                                <label for="daily_price" class="block text-sm font-medium text-gray-700 mb-1">Günlük Kiralama Ücreti</label>
                                <input type="number" step="0.01" class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 @error('daily_price') border-red-500 @enderror" id="daily_price" name="daily_price" value="{{ old('daily_price', $vehicle->daily_price) }}" required>
                                @error('daily_price')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="mb-4">
                                <label for="status" class="block text-sm font-medium text-gray-700 mb-1">Durum</label>
                                <select class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 @error('status') border-red-500 @enderror" id="status" name="status" required>
                                    <option value="available" {{ old('status', $vehicle->status) == 'available' ? 'selected' : '' }}>Müsait</option>
                                    <option value="rented" {{ old('status', $vehicle->status) == 'rented' ? 'selected' : '' }}>Kirada</option>
                                    <option value="maintenance" {{ old('status', $vehicle->status) == 'maintenance' ? 'selected' : '' }}>Bakımda</option>
                                </select>
                                @error('status')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <div class="mb-4">
                            <label for="description" class="block text-sm font-medium text-gray-700 mb-1">Açıklama</label>
                            <textarea class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 @error('description') border-red-500 @enderror" id="description" name="description" rows="3">{{ old('description', $vehicle->description) }}</textarea>
                            @error('description')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="flex justify-between mt-6">
                            <a href="{{ route('admin.vehicles.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-300 text-gray-800 rounded hover:bg-gray-400">Geri</a>
                            <button type="submit" class="inline-flex items-center px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600">
                                Güncelle
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-admin-layout> 
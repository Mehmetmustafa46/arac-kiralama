<x-admin-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="flex justify-between items-center mb-6">
                        <h1 class="text-2xl font-semibold">Araçlar</h1>
                        <a href="{{ route('admin.vehicles.create') }}" class="px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600">Yeni Araç Ekle</a>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Marka</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Model</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Yıl</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Plaka</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Renk</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Günlük Ücret</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Durum</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">İşlemler</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach($vehicles as $vehicle)
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap">{{ $vehicle->id }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap">{{ $vehicle->brand }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap">{{ $vehicle->model }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap">{{ $vehicle->year }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap">{{ $vehicle->plate_number }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap">{{ $vehicle->color }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap">{{ number_format($vehicle->daily_price, 2) }} ₺</td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            @switch($vehicle->status)
                                                @case('available')
                                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">Müsait</span>
                                                    @break
                                                @case('rented')
                                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">Kirada</span>
                                                    @break
                                                @case('maintenance')
                                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">Bakımda</span>
                                                    @break
                                            @endswitch
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                            <a href="{{ route('admin.vehicles.edit', $vehicle) }}" class="text-indigo-600 hover:text-indigo-900 mr-3">Düzenle</a>
                                            <form action="{{ route('admin.vehicles.destroy', $vehicle) }}" method="POST" class="inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-red-600 hover:text-red-900" onclick="return confirm('Bu aracı silmek istediğinizden emin misiniz?')">Sil</button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-admin-layout> 
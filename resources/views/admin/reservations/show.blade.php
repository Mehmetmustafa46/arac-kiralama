                            @switch($reservation->status)
                                @case('pending')
                                    <span class="badge bg-warning">Beklemede</span>
                                    @break
                                @case('confirmed')
                                    <span class="badge bg-success">Onaylandı</span>
                                    @break
                                @case('cancelled')
                                    <span class="badge bg-danger">İptal Edildi</span>
                                    @break
                                @case('completed')
                                    <span class="badge bg-info">Tamamlandı</span>
                                    @break
                            @endswitch
                            <form action="{{ route('admin.reservations.update', $reservation->id) }}" method="POST" class="d-inline-block me-2">
                                @csrf
                                @method('PUT')
                                <input type="hidden" name="status" value="pending">
                                <button type="submit" class="btn btn-warning">Beklemede</button>
                            </form>
                            <form action="{{ route('admin.reservations.update', $reservation->id) }}" method="POST" class="d-inline-block me-2">
                                @csrf
                                @method('PUT')
                                <input type="hidden" name="status" value="confirmed">
                                <button type="submit" class="btn btn-success">Onayla</button>
                            </form>
                            <form action="{{ route('admin.reservations.update', $reservation->id) }}" method="POST" class="d-inline-block me-2">
                                @csrf
                                @method('PUT')
                                <input type="hidden" name="status" value="cancelled">
                                <button type="submit" class="btn btn-danger">İptal Et</button>
                            </form>
                            <form action="{{ route('admin.reservations.update', $reservation->id) }}" method="POST" class="d-inline-block">
                                @csrf
                                @method('PUT')
                                <input type="hidden" name="status" value="completed">
                                <button type="submit" class="btn btn-info">Tamamlandı</button>
                            </form> 
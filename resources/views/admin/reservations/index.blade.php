                                            <li>
                                                <form action="{{ route('admin.reservations.update', $reservation) }}" method="POST">
                                                    @csrf
                                                    @method('PUT')
                                                    <input type="hidden" name="status" value="confirmed">
                                                    <button type="submit" class="dropdown-item text-success">
                                                        <i class="fas fa-check me-2"></i>Onayla
                                                    </button>
                                                </form>
                                            </li>
                                            <li>
                                                <form action="{{ route('admin.reservations.update', $reservation) }}" method="POST">
                                                    @csrf
                                                    @method('PUT')
                                                    <input type="hidden" name="status" value="cancelled">
                                                    <button type="submit" class="dropdown-item text-danger">
                                                        <i class="fas fa-times me-2"></i>İptal Et
                                                    </button>
                                                </form>
                                            </li>
                                            <li>
                                                <form action="{{ route('admin.reservations.update', $reservation) }}" method="POST">
                                                    @csrf
                                                    @method('PUT')
                                                    <input type="hidden" name="status" value="completed">
                                                    <button type="submit" class="dropdown-item text-info">
                                                        <i class="fas fa-check-double me-2"></i>Tamamlandı
                                                    </button>
                                                </form>
                                            </li> 
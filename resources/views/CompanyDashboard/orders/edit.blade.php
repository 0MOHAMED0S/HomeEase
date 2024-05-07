<div class="modal fade" id="Edit-{{ $order->id }}" tabindex="-1" aria-labelledby="Edit-{{ $order->id }}"
    aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Edit Company Status</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form method="POST" action="{{ route('UpdateOrder', ['id' => $company->id,'od'=>$order->id]) }}" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <select class="form-select" aria-label="Default select example" name="status">
                        <option value="pending" {{ $company->status === 'pending' ? 'selected' : '' }}>Pending</option>
                        <option value="accept" {{ $company->status === 'accept' ? 'accept' : '' }}>Accept</option>
                        <option value="cancel" {{ $company->status === 'cancel' ? 'selected' : '' }}>Cancel</option>
                        <option value="completed" {{ $company->status === 'completed' ? 'selected' : '' }}>Completed</option>
                    </select>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save Changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

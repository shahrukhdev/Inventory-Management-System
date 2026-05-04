<div class="text-center mb-2">
    <h1 class="mb-1">Edit Maintenance History</h1>
</div>

<form id="edit-invoicehistory-form" class="row gy-1 pt-75" method="post" action="{{ route('productitem.history.update', $history->id) }}">
    @csrf
    <input type="hidden" name="id" class="history_id" value="{{ $history->id }}">
    <input type="hidden" name="product_item_id" class="product_item_id" value="{{ $history->product_item_id }}">

    <div class="col-12">
        <label class="form-label" for="modalEditProductHistoryTitle">Title</label>
        <input type="text" id="modalEditProductHistoryTitle" name="title" class="form-control"
               value="{{ $history->title }}" placeholder="Title" autocomplete="off" required/>
        <div class="text-danger d-none"></div>
    </div>

    <div class="col-12">
        <label class="form-label" for="modalEditProductHistoryDescription">Description</label>
        <input type="text" id="modalEditProductHistoryDescription" name="description" class="form-control"
               value="{{ $history->description }}" placeholder="Description" autocomplete="off" required/>
    </div>

    <div class="col-12">
        <label class="form-label" for="modalEditProductHistoryAmount">Description</label>
        <input type="text" id="modalEditProductHistoryAmount" name="amount" class="form-control"
               value="{{ $history->amount }}" placeholder="Amount" autocomplete="off" required/>
    </div>

    <div class="col-12 text-center mt-2 pt-50">
        <button type="submit" class="btn btn-primary me-1" id="update_brand">Update</button>
        <button type="reset" class="btn btn-outline-secondary" data-bs-dismiss="modal"
                aria-label="Close">
            Discard
        </button>
    </div>
</form>

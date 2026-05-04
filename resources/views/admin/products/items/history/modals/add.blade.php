<div class="modal fade" id="addHistoryModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered modal-add-department">
        <div class="modal-content">
            <div class="modal-header bg-transparent">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"
                    id="close-add-department"></button>
            </div>
            <div class="modal-body pb-5 px-sm-5 pt-50">
                <div class="text-center mb-2">
                    <h1 class="mb-1">Add Maintenance History</h1>
                </div>
                    <form id="add-maintenance-history-form" class="row gy-1 pt-75" action="{{ route('productitem.history.store') }}" method="POST">
                       @csrf
                       <input type="hidden" name="product_item_id" value="{{ $item->id }}">

                    <div class="col-12">
                        <label class="form-label" for="modalAddTitle">Title</label>
                        <input type="text" id="modalAddTitle" name="title" class="form-control" placeholder="Title" autocomplete="off" required />
                        <div class="text-danger d-none"></div>
                    </div>

                    <div class="col-12">
                        <label class="form-label" for="modalAddDescription">Description</label>
                        <input type="text" id="modalAddDescription" name="description" class="form-control" placeholder="Description" autocomplete="off" required />
                        <div class="text-danger d-none"></div>
                    </div>

                    <div class="col-12">
                        <label class="form-label" for="modalAddAmount">Amount</label>
                        <input type="number" id="modalAddAmount" name="amount" class="form-control" placeholder="Amount" autocomplete="off" required />
                        <div class="text-danger d-none"></div>
                    </div>

                    <div class="col-12 text-center mt-2 pt-50">
                        <button type="submit" class="btn btn-primary me-1" id="create_department">Submit</button>
                        <button type="reset" class="btn btn-outline-secondary add-department-close-btn" data-bs-dismiss="modal" aria-label="Close">Discard</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

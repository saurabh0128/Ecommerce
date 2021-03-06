<!--notifications sidebar -->
<div class="sidebar" id="notifications">
    <div class="sidebar-header d-block align-items-end">
        <div class="align-items-center d-flex justify-content-between py-4">
            Notifications
            <button data-sidebar-close>
                <i class="bi bi-arrow-right"></i>
            </button>
        </div>
        <!-- <ul class="nav nav-pills">
            <li class="nav-item">
                <a class="nav-link active nav-link-notify" data-bs-toggle="tab" href="#notes">Notes</a>
            </li>
        </ul> -->
    </div>

    <div class="sidebar-content">
        <div class="tab-content">
             <div class="tab-pane active">
                <div class="tab-pane-body">
                    <ul class="list-group list-group-flush">
                        <!-- all Notification view in li tag -->
                        <li class="px-0 list-group-item" id="all-noti" style="cursor:pointer;"></li>
                    </ul>
                </div>
                <div class="tab-pane-footer">
                     <a href="#" class="btn btn-success" id="read-all">
                        <i class="bi bi-check2 me-2"></i> Make All Read
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- ./ notifications sidebar
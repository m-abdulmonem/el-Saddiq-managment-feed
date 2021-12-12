<div class="modal fade" id="discardedModal" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel">@lang("$trans.close_daily")</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>

            </div>
            <!-- ./modal-header -->
            <div class="modal-body">
                <discarded-sale></discarded-sale>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary btn-close" data-dismiss="modal">@lang("home.close")</button>
                <button type="submit" class="btn btn-info">@lang("$trans.continuation")</button>
            </div>

            <!-- ./form -->
        </div>
    </div>
</div>

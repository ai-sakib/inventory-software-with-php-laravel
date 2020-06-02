<script type="text/javascript">
    function addPage(route, name){
        var modal=$('#quickViewModal');
        var modalTitle=$('#quickViewModalTitle');
        var modalBody=$('#quickViewModalBody');
        var modalFooter=$('#quickViewModalFooter');
        modal.modal('toggle');
        modalFooter.hide();
        //modalBody.html('<center><img src="{{url('public/loader.gif')}}"></center>');
        $.ajax({
            url: "{{url('/')}}/"+route+"/create",
            type: 'GET',
            data: {},
        })
        .done(function(item) {
            modalTitle.html('Add '+name);
            modalBody.html(item);
            //modalFooter.show();
        })
        .fail(function() {
            modal.modal('toggle');
        });
    }

    function editPage(route, id, name){
        var modal=$('#quickViewModal');
        var modalTitle=$('#quickViewModalTitle');
        var modalBody=$('#quickViewModalBody');
        var modalFooter=$('#quickViewModalFooter');
        modal.modal('toggle');
        modalFooter.hide();
        //modalBody.html('<center><img src="{{url('public/loader.gif')}}"></center>');
        $.ajax({
            url: "{{url('/')}}/"+route+"/"+id+"/edit",
            type: 'GET',
            data: {},
        })
        .done(function(item) {
            modalTitle.html('Edit '+name);
            modalBody.html(item);
            //modalFooter.show();
        })
        .fail(function() {
            modal.modal('toggle');
        });
    }
</script>
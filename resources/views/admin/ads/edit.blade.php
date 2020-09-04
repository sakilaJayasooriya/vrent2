@php 
$form_data = [
    'page_title'=> 'Edit Advertisement',
    'page_subtitle'=> '', 
    'form_name' => 'Edit Advertisement Form',
    'form_id' => 'edit_advertisement',     
    'action' => URL::to('/').'/admin/settings/edit-ads/'.@$result->id,
    'fields' => [
        ['type' => 'text', 'class' => '', 'label' => ' Advertisement Name', 'name' => 'name', 'value' => $result->name],
        ['type' => 'textarea', 'class' => '', 'label' => ' content', 'name' => 'content', 'value' =>$result->content],
      
        ['type' => 'select', 'options' => ['Active' => 'Active', 'Inactive' => 'Inactive'], 'class' => 'validate_field', 'label' => 'Status', 'name' => 'status', 'value' => $result->status],
        ['type' => 'select', 'options' => ['Slidebar' => 'Slidebar', 'Horizontal' => 'Horizontal'], 'class' => 'validate_field', 'label' => 'Possition', 'name' => 'possition', 'value' => $result->possition],


    ]
  ];
@endphp
@include("admin.common.form.setting", $form_data)

<script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/additional-methods.min.js"></script>

<script type="text/javascript">
   $(document).ready(function () {

            $('#edit_advertisement').validate({
                rules: {
                    name: {
                        required: true
                    },
                    content: {
                        required: true,
                    }
                }
            });

        });
</script>
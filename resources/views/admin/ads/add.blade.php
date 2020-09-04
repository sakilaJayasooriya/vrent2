@php 
$form_data = [
    'page_title'=> 'Add Advertisement',
    'page_subtitle'=> '', 
    'form_name' => 'Add Advertisement Form',
    'form_id' => 'add_advertisement',
    'action' => URL::to('/').'/admin/settings/add-ads',
    'fields' => [
      ['type' => 'text', 'class' => '', 'label' => ' Advertisement Name', 'name' => 'name', 'value' => ''],
      ['type' => 'textarea', 'class' => '', 'label' => ' content', 'name' => 'content', 'value' => ''],
      
      ['type' => 'select', 'options' => ['Active' => 'Active', 'Inactive' => 'Inactive'], 'class' => 'validate_field', 'label' => 'Status', 'name' => 'status', 'value' => ''],
      ['type' => 'select', 'options' => ['Slidebar' => 'Slidebar', 'Horizontal' => 'Horizontal'], 'class' => 'validate_field', 'label' => 'Possition', 'name' => 'possition', 'value' => ''],

    ]
  ];
@endphp
@include("admin.common.form.setting", $form_data)

<script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/additional-methods.min.js"></script>

<script type="text/javascript">
   $(document).ready(function () {

            $('#add_advertisement').validate({
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
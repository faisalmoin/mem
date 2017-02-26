 <script>
  $('#form').submit(function () {
    var vname = $.trim($('#vendorcontactname').val());
    var sname = $.trim($('#shippingcontactname').val());
    if (vname === '' || sname === '') {
        alert('Text-field is empty.');
       // $('#submit').prop('disabled', true);
        return false;
    }
    
  });




  $(document).ready(function () {
   
    $('form[name="form"]').on("submit", function (e) {
        
        var vname = $(this).find('input[name="vendorcontactname"]');
        if ($.trim(vname.val()) === "") {
            alert();
            e.preventDefault();
            alert('Please fill required fields'); 
            $('#submit').prop('disabled', true);   
               
        } else {
            e.preventDefault(); 
            $('#submit').prop('disabled', false);   
           
        }
    });
    
    $(".alert").find(".close").on("click", function (e) {
        
        e.stopPropagation();  
        e.preventDefault();    
        $(this).closest(".alert").slideUp(400);   
    });
});
  </script>
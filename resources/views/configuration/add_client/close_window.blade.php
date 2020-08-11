Cliente agregado.  <a href="#" onclick="doTheSubmit();">Click acá</a> para cerrar ventana.
<script>
    function doTheSubmit() {
      var doc = window.opener.document,
      theForm = doc.getElementById("first_form");
      window.close();
      theForm.submit();
    }
  </script>

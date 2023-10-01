const Toast = Swal.mixin({
    toast: true,
    position: "top-end",
    showConfirmButton: false,
    timer: 3000,
    timerProgressBar: true,
    didOpen: (toast) => {
      toast.addEventListener("mouseenter", Swal.stopTimer);
      toast.addEventListener("mouseleave", Swal.resumeTimer);
    },
  });
  
  $(document).ready(function () {

    $("select").select2();

    $("#etablissement").on("change", async function () {
      const id_etab = $(this).val();
      console.log(id_etab);
      let response = "";
      if (id_etab != "") {
        const request = await axios.get("/api/formation/" + id_etab);
        response = request.data;
      }
      $("#formation").html(response).select2();
    });
    $("#formation").on("change", async function () {
      const id_formation = $(this).val();
      let response = "";
      // alert(id_formation);
      if (id_formation != "") {
        const request = await axios.get("/api/promotion/" + id_formation);
        response = request.data;
      }
      $("#promotion").html(response).select2();
    });
    $("#promotion").on("change", async function () {
      const id_promotion = $(this).val();
  
      if (id_promotion != "") {
          const request = await axios.get("/api/etudiants/" + id_promotion);
          response = request.data;
          console.log('response');
          
      }
      $("#etudiant").html(response).select2();
    });

    $("body #search").on("click", async function(e) {
        e.preventDefault()
        
        const id_etudiant = $("body #etudiant").val();
        const date_debut = $("body #date_debut").val();
        const date_fin = $("body #date_fin").val();
        console.log(id_etudiant);
        console.log(date_debut);
        console.log(date_fin);
      if(!id_etudiant || !date_debut || !date_fin ){
        Toast.fire({
          icon: 'error',
          title: 'Veuillez remplire tous les champs!',
        })
        return;
      }

      const formData = new FormData();
    formData.append('id_etudiant', id_etudiant);
    formData.append('date_debut', date_debut);
    formData.append('date_fin', date_fin);
      
        
      const icon = $("#search i");
  
      try {
          icon.removeClass('fa-search').addClass("fa-spinner fa-spin ");
          const request = await axios.post('/assiduite/pointage/search', formData, {
            headers: {
              'Content-Type': 'multipart/form-data', // Set content type to multipart/form-data
            },
          });
          const response = request.data;
          console.log(response);
          $('body #pointage').html(response.html);

            if ($.fn.DataTable.isDataTable("body #datatables_pointages")) {
            $("body #datatables_pointages").DataTable().clear().destroy();
            }

            $("body #datatables_pointages").DataTable({
            language: {
                url: "//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/French.json",
            }
            });
          icon.addClass('fa-search').removeClass("fa-spinner fa-spin ");
          table.ajax.reload();
      } catch (error) {
          console.log(error, error.response);
          const message = error.response;
          Toast.fire({
              icon: 'error',
              title: message,
            })
          icon.addClass('fa-search').removeClass("fa-spinner fa-spin ");
      }
  
    })
  
  });
  
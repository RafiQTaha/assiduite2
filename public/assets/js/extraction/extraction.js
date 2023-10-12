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

    // $("#etablissement").on("change", async function () {
    //   const id_etab = $(this).val();
    //   console.log(id_etab);
    //   let response = "";
    //   if (id_etab != "") {
    //     const request = await axios.get("/api/formation/" + id_etab);
    //     response = request.data;
    //   }
    //   $("#formation").html(response).select2();
    // });
    // $("#formation").on("change", async function () {
    //   const id_formation = $(this).val();
    //   let response = "";
    //   // alert(id_formation);
    //   if (id_formation != "") {
    //     const request = await axios.get("/api/promotion/" + id_formation);
    //     response = request.data;
    //   }
    //   $("#promotion").html(response).select2();
    // });
    // $("#promotion").on("change", async function () {
    //   $("#etudiant").empty();
    //   const id_promotion = $(this).val();
  
    //   if (id_promotion != "") {
    //       const request = await axios.get("/api/etudiants/" + id_promotion);
    //       response = request.data;
    //       console.log('response');
          
    //   }
    //   $("#etudiant").html(response).select2();
    // });

    $("#extraction").on("click",function(e) {
        e.preventDefault()
        
        const date_debut = $("body #date_debut").val();
        const date_fin = $("body #date_fin").val();
        console.log(date_debut);
        console.log(date_fin);
      if(!date_debut || !date_fin ){
        Toast.fire({
          icon: 'error',
          title: 'Veuillez remplire tous les champs!',
        })
        return;
      }
              
      window.open(
        "/extraction/extractionGlobal/"+date_debut+"/"+date_fin,
        "_blank"
      );
  
    })
    
  
  });
  
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
  let id_seance;
  var table = $("#datatables_gestion_seances").DataTable({
    lengthMenu: [
      [10, 15, 25, 50, 100, 20000000000000],
      [10, 15, 25, 50, 100, "All"],
    ],
    order: [[0, "desc"]],
    ajax: "/assiduite/traitement/list",
    processing: true,
    serverSide: true,
    deferRender: true,
    language: {
      url: "//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/French.json",
    },
  });
  $("#etablissement").select2();
  $("body").on("click", "#datatables_gestion_seances tbody tr", function () {
    // const input = $(this).find("input");

    if ($(this).hasClass("active_databales")) {
      $(this).removeClass("active_databales");
      id_seance = null;
    } else {
      $("#datatables_gestion_seances tbody tr").removeClass("active_databales");
      $(this).addClass("active_databales");
      id_seance = $(this).attr("id");
    }
    $("body .small-box").removeClass("active");
  });
  $("#day").on("change", async function () {
    const day = $(this).val();
    if (day || day != "") {
      table.columns(0).search($(this).val()).draw();
    } else {
      table.columns(0).search("").draw();
    }
  });
  $("#etablissement").on("change", async function () {
    const id_etab = $(this).val();
    let response = "";
    if (id_etab != "") {
      const request = await axios.get("/api/formation/" + id_etab);
      response = request.data;
      table.columns(1).search($(this).val()).draw();
    } else {
      table.columns(1).search("").draw();
    }
    $("#formation").html(response).select2();
  });
  $("#formation").on("change", async function () {
    const id_formation = $(this).val();
    let response = "";
    // alert(id_formation);
    if (id_formation != "") {
      table.columns(2).search(id_formation).draw();
      const request = await axios.get("/api/promotion/" + id_formation);
      response = request.data;
    } else {
      table.columns(2).search("").draw();
    }
    $("#promotion").html(response).select2();
  });
  $("#promotion").on("change", async function () {
    const id_promotion = $(this).val();

    if (id_promotion != "") {
      table.columns(3).search(id_promotion).draw();
      //   const request = await axios.get("/api/semestre/" + id_promotion);
      //   response = request.data;
    } else {
      table.columns(3).search("").draw();
    }
    // $("#semestre").html(response).select2();
  });
  
  $("#modifiersalle").on("click", async () => {
      // alert($("#formation").val())
    var salle = $("#salles").val();
    if(!id_seance){
      Toast.fire({
        icon: 'error',
        title: 'Veuillez choissir une séance!',
      })
      return;
    }
    if(!salle){
        Toast.fire({
          icon: 'error',
          title: 'Veuillez choissir une salle!',
        })
        return;
    }
      
    const icon = $("#modifiersalle i");

    try {
        icon.remove('fa-edit').addClass("fa-spinner fa-spin ");
        const request = await axios.get('/assiduite/traitement/modifiersalle/'+id_seance+'/'+salle);
        const response = request.data;
        console.log(response);
        Toast.fire({
          icon: 'success',
          title: 'La salle est bien modifiée!',
        })
        icon.addClass('fa-edit').removeClass("fa-spinner fa-spin ");
        table.ajax.reload();
    } catch (error) {
        console.log(error, error.response);
        const message = error.response.data;
        Toast.fire({
            icon: 'error',
            title: message,
          })
        icon.addClass('fa-edit').removeClass("fa-spinner fa-spin ");
    }

  })
  // $("#modifier").on("click", async function(){
  //     if(!id_seance){
  //         Toast.fire({
  //           icon: 'error',
  //           title: 'Veuillez selectioner une ligne!',
  //         })
  //         return;
  //     }
  //     const icon = $("#modifier i");

  //     try {
  //         icon.remove('fa-edit').addClass("fa-spinner fa-spin ");
  //         const request = await axios.get('/parametre/element/details/'+id_seance);
  //         const response = request.data;
  //         console.log(response)
  //         icon.addClass('fa-edit').removeClass("fa-spinner fa-spin ");
  //         $("body #modifier_modal #udpate").html(response)
  //         $('select').select2();
  //         $("#modifier_modal").modal("show")
  //     } catch (error) {
  //         console.log(error, error.response);
  //         const message = error.response.data;
  //         Toast.fire({
  //             icon: 'error',
  //             title: message,
  //           })
  //         icon.addClass('fa-edit').removeClass("fa-spinner fa-spin ");
  //     }

  // })
  // $("#save").on("submit", async (e) => {
  //     e.preventDefault();
  //     var formData = new FormData($("#save")[0])
  //     formData.append("module_id", $("#module").val());
  //     const icon = $("#save i");
  //     try {
  //         icon.remove('fa-check-circle').addClass("fa-spinner fa-spin ");
  //         const request = await axios.post('/parametre/element/new', formData);
  //         const response = request.data;
  //         icon.addClass('fa-check-circle').removeClass("fa-spinner fa-spin ");
  //         $('#save')[0].reset();
  //         table.ajax.reload();
  //         id_seance = false;
  //         $("#ajout_modal").modal("hide")
  //         Toast.fire({
  //             icon: 'success',
  //             title: response,
  //         })
  //     } catch (error) {
  //         console.log(error, error.response);
  //         const message = error.response.data;
  //         Toast.fire({
  //             icon: 'error',
  //             title: message,
  //           })
  //         icon.addClass('fa-check-circle').removeClass("fa-spinner fa-spin ");
  //     }
  // })
  // $("#udpate").on("submit", async (e) => {
  //     e.preventDefault();
  //     var formData = new FormData($("#udpate")[0])
  //     const icon = $("#udpate i");
  //     try {
  //         icon.remove('fa-check-circle').addClass("fa-spinner fa-spin ");
  //         const request = await axios.post('/parametre/element/update/'+id_seance, formData);
  //         const response = request.data;
  //         icon.addClass('fa-check-circle').removeClass("fa-spinner fa-spin ");
  //         id_seance = false;
  //         table.ajax.reload();
  //         $("#modifier_modal").modal("hide")
  //         Toast.fire({
  //             icon: 'success',
  //             title: response,
  //           })
  //         icon.addClass('fa-edit').removeClass("fa-spinner fa-spin ");
  //     } catch (error) {
  //         console.log(error, error.response);
  //         const message = error.response.data;
  //         Toast.fire({
  //             icon: 'error',
  //             title: message,
  //           })
  //         icon.addClass('fa-check-circle').removeClass("fa-spinner fa-spin ");
  //     }
  // })

  // $('body').on('click','#extraction_architecture', async function (e) {
  //     e.preventDefault();
  //     const icon = $("#extraction_architecture i");
  //     window.open('/parametre/element/extraction_architecture', '_blank');
  // })

  $("#traiter").on("click", async function () {
    if (!id_seance) {
      Toast.fire({
        icon: "error",
        title: "Veuillez selectioner une ligne!",
      });
      return;
    }
    const icon = $("#traiter i");
    // alert(id_seance)
    // var res = confirm('Vous voulez vraiment traiter cette seance ?');
    // if(res == 1){
    try {
      $("body .small-box").removeClass("active");
      icon.remove("fa-edit").addClass("fa-spinner fa-spin ");
      const request = await axios.post("/assiduite/traitement/traiter/" + id_seance);
      const response = request.data;
      table.ajax.reload();
      // id_seance = false
      icon.addClass("fa-edit").removeClass("fa-spinner fa-spin ");
      Toast.fire({
        icon: "success",
        title: response.message,
      });
      // console.log(response.data['A'])
      $("body .a").find(".number").text(response.data["A"]);
      $("body .b").find(".number").text(response.data["B"]);
      $("body .c").find(".number").text(response.data["C"]);
      $("body .d").find(".number").text(response.data["D"]);
      $("body .small-box").addClass("active");
    } catch (error) {
      console.log(error, error.response);
      const message = error.response.data;
      Toast.fire({
        icon: "error",
        title: message,
      });
      icon.addClass("fa-edit").removeClass("fa-spinner fa-spin ");
    }
    // }
  });

  
  $("body #parlot_search").on("click", async function (e) {
    e.preventDefault()
    var hd = $("body #hd").val();
    var hf = $("body #hf").val();
    var date = $("body #day").val();
    // var date = $("body #datetime").val();
    // console.log(hd, hf);

    if (!hd) {
      Toast.fire({
        icon: 'error',
        title: 'Veuillez remplir la date Debut !',
        });
      return;
    }
    if (!hf) {
      Toast.fire({
        icon: 'error',
        title: 'Veuillez remplir la date Fin !',
        });
      return;
    }

    const icon = $("#parlot_search i");

    try {
        icon.remove('fa-search').addClass("fa-spinner fa-spin ");
        const request = await axios.get('/assiduite/traitement/parlot/'+hd+"/"+hf+"/"+date);
        const response = request.data;

        $('body #parlot_datatable').html(response.html);

        if ($.fn.DataTable.isDataTable("body #parlot_datatable")) {
          $("body #parlot_datatable").DataTable().clear().destroy();
        }

        $("body #parlot_datatable").DataTable({
          language: {
            url: "//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/French.json",
          },
        });


        icon.addClass('fa-search').removeClass("fa-spinner fa-spin ");
        table.ajax.reload();
    } catch (error) {
        console.log(error, error.response);
        const message = error.response.data;
        Toast.fire({
            icon: 'error',
            title: message,
          })
        icon.addClass('fa-edit').removeClass("fa-spinner fa-spin ");
    }
  });
  // var seances = [];
  // $("#check").on("click", async function (e) {
  //   e.preventDefault();
    
  //   $("#parlot_datatable input[type='checkbox']").each(function () {
  //     if ($(this).is(":checked")) {
  //       seances.push($(this).attr("id"));
  //     }else {
  //       $(this).prop("checked", true);
  //       seances.push($(this).attr("id"));
  //     }
  //   });
  //   console.log(seances);
  // });

  // !!!!!!! heree
  seances = [];
  $("body").on("click", "#check", function () {
    // alert('test')
    const se = $("body .check_seance");
    if ($("#check").prop("checked") == true) {
        se.prop("checked", true);
        se.map(function () {
          seances.push(this.value);
        });
        $("#check").prop("checked", false);
        // console.log(admissions);
    } else {
        se.prop("checked", false);
        seances = [];
    }
    console.log(seances);
});

});

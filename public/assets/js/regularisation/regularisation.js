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
        $("#excel_seance").on("click", async () => {
            if (!$('#formFileLg')[0].files[0]) {
                Toast.fire({
                  icon: "error",
                  title: "Veuillez insérer un fichier Xlsx!",
                });
                return;
            }
                const icon = $("#excel_seance i");
                var fileInput = $('#formFileLg')[0]; // Get the file input element
                var formData = new FormData(); // Create a FormData object
                formData.append('file', fileInput.files[0]); // Append the selected file
          
              try {
                  icon.removeClass('fa-file-excel').addClass("fa-spinner fa-spin ");
                  const request = await axios.post('/regularisation_seance', formData);
                  const response = request.data;
                  console.log(response);
                  Toast.fire({
                    icon: 'success',
                    title: 'Regularisation est bien fait.',
                  })
                  icon.addClass('fa-file-excel').removeClass("fa-spinner fa-spin ");
              } catch (error) {
                  console.log(error, error.response);
                  const message = error.response.data.error;
                Toast.fire({
                    icon: 'error',
                    title: message,
                })
                  icon.addClass('fa-file-excel').removeClass("fa-spinner fa-spin ");
              }
        })

        $("#excel_date").on("click", async () => {
            if (!$('#formFileLg')[0].files[0]) {
                Toast.fire({
                  icon: "error",
                  title: "Veuillez insérer un fichier Xlsx!",
                });
                return;
            }
                const icon = $("#excel_seance i");
                var fileInput = $('#formFileLg')[0]; // Get the file input element
                var formData = new FormData(); // Create a FormData object
                formData.append('file', fileInput.files[0]); // Append the selected file
          
              try {
                  icon.removeClass('fa-file-excel').addClass("fa-spinner fa-spin ");
                  const request = await axios.post('/regularisation_date', formData);
                  const response = request.data;
                  console.log(response);
                  Toast.fire({
                    icon: 'success',
                    title: 'Regularisation est bien fait.',
                  })
                  icon.addClass('fa-file-excel').removeClass("fa-spinner fa-spin ");
              } catch (error) {
                  console.log(error, error.response);
                  const message = error.response.data.error;
                Toast.fire({
                    icon: 'error',
                    title: message,
                })
                  icon.addClass('fa-file-excel').removeClass("fa-spinner fa-spin ");
              }
        })
        
        
            $("#canvas_date").on("click", function () {
            window.open("/canvas_date", "_blank");
            });
        
            $("#canvas_seance").on("click", function () {
            window.open("/canvas", "_blank");
            });
    })
   
              
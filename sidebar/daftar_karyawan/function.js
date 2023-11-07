document.addEventListener("DOMContentLoaded", function () {
  function toggleForm() {
    const formContainer = document.getElementById("formContainer");
    const submitBtn = document.querySelector("button[name='submit']");
    const cancelBtn = document.getElementById("btnCancel");
    const tambahKaryawanBtn = document.getElementById("btnTambahKaryawan");
    const judulHlm = document.getElementById("judulHlm");

    if (formContainer.style.display === "none") {
      formContainer.style.display = "block";
      submitBtn.style.display = "inline-block";
      cancelBtn.style.display = "inline-block";
      tambahKaryawanBtn.style.display = "none"; // Hide the "Tambah Karyawan" button
      judulHlm.style.display = "none"; // Hide the "judulHlm" element when the form is displayed
    } else {
      formContainer.style.display = "none";
      submitBtn.style.display = "none";
      cancelBtn.style.display = "none";
      tambahKaryawanBtn.style.display = "inline-block"; // Show the "Tambah Karyawan" button
      judulHlm.style.display = "block"; // Show the "judulHlm" element when the form is hidden
    }
  }

  const btnTambahKaryawan = document.getElementById("btnTambahKaryawan");
  btnTambahKaryawan.addEventListener("click", toggleForm);

  const btnCancel = document.getElementById("btnCancel");
  btnCancel.addEventListener("click", toggleForm);
});
// search
let timeoutId;
const searchInput = document.querySelector(".form-control");
searchInput.addEventListener("input", delayedSearch);
searchKaryawan();

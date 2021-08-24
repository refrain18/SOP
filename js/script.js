const menuToggle = document.querySelector('.menu-toggle input');
const nav = document.querySelector('nav ul');


menuToggle.addEventListener('click', function () {
  nav.classList.toggle('slide');
});


/* When the user clicks on the button, 
toggle between hiding and showing the dropdown content */
function myFunction() {
  document.getElementById("myDropdown").classList.toggle("show");
}

// Close the dropdown if the user clicks outside of it
window.onclick = function (event) {
  if (!event.target.matches('.dropbtn')) {
    var dropdowns = document.getElementsByClassName("dropdown-content");
    var i;
    for (i = 0; i < dropdowns.length; i++) {
      var openDropdown = dropdowns[i];
      if (openDropdown.classList.contains('show')) {
        openDropdown.classList.remove('show');
      }
    }
  }
}

function myFunction1() {
  document.getElementById("myDropdown1").classList.toggle("show");
}

// Close the dropdown if the user clicks outside of it
window.onclick = function (event) {
  if (!event.target.matches('.dropbtn1')) {
    var dropdowns = document.getElementsByClassName("dropdown-content1");
    var i;
    for (i = 0; i < dropdowns.length; i++) {
      var openDropdown = dropdowns[i];
      if (openDropdown.classList.contains('show')) {
        openDropdown.classList.remove('show');
      }
    }
  }
}

function myFunction2() {
  document.getElementById("myDropdown2").classList.toggle("show");
}

// Close the dropdown if the user clicks outside of it
window.onclick = function (event) {
  if (!event.target.matches('.dropbtn2')) {
    var dropdowns = document.getElementsByClassName("dropdown-content2");
    var i;
    for (i = 0; i < dropdowns.length; i++) {
      var openDropdown = dropdowns[i];
      if (openDropdown.classList.contains('show')) {
        openDropdown.classList.remove('show');
      }
    }
  }
}

function myFunction3() {
  document.getElementById("myDropdown3").classList.toggle("show");
}

// Close the dropdown if the user clicks outside of it
window.onclick = function (event) {
  if (!event.target.matches('.dropbtn3')) {
    var dropdowns = document.getElementsByClassName("dropdown-content3");
    var i;
    for (i = 0; i < dropdowns.length; i++) {
      var openDropdown = dropdowns[i];
      if (openDropdown.classList.contains('show')) {
        openDropdown.classList.remove('show');
      }
    }
  }
}

// Menghilangkan Notif dalam interval waktu tertentu
$('#notif').delay(3000).fadeOut(300);

function timeEstCalc(context) {
  // console.log("Checkbox clicked...");
  let totalResTimeContext = context.find("#totalSopTimeEst");
  let sopArr = [];

  $('.sop_checkbox').each(function () {
    if ($(this).is(":checked")) {
      sopArr.push($(this).val());
    }
  });

  sopArr = sopArr.toString();

  $.ajax({
    url: "request/sop-time-sum.php",
    method: "POST",
    dataType: "json",
    data: { sopArr: sopArr },
    success: function (res) {
      if (res.status) {
        // console.log(res);
        $(totalResTimeContext[0]).val(res.data != "" ? res.data.total_sop_time_est : "00:00");
      }
    },
    error: function () {
      alert("Terjadi kesalahan!");
    }
  });
}

function sendTabIdsToCurrentModal(id) {
  try {
    $(window.modal_user_id).val(id);
    alert('Percobaan Berhasil!');
  } catch (e) {
    alert('Terjadi kesalahan pada program. . .\nPesan: ' + e);
  }
}

function validateSopForm(context) {
  try {
    if (!confirm('Waktu akan dijalankan. Apa anda yakin untuk memulai?')) { return false; }

    // Persiapan konteks form dan var tmp
    let formSopStarter = context,
      fileImgPath = context.foto_pegawai,
      checkboxArr = context.elements['pilihan_jenis_perawatan[]'],
      timeStamp = context.time_stamp.value,
      id_user = context.modal_user_id.value,
      totalSopTimeEst = context.totalSopTimeEst.value;
    // id_user = context.id_user.value;
    let checkArr = [], textCheckboxArr = [], checkboxTexts = '';

    // Validasi input file
    let fileImg = fileImgPath.files;
    let fileSize = Math.round((fileImg[0].size / 1024));
    let fileName = fileImg[0].name.length;
    let allowedExtensions = /(\.jpg|\.jpeg|\.png)$/i;

    if (!allowedExtensions.exec(fileImgPath.value)) {
      alert('Foto yang di input invalid! foto harus bertipe jpg/jpeg/png!');
      fileImgPath.value = '';
      return false;
    } else if (fileSize > 3072) {
      alert('Foto yang di input invalid! foto maksimal berukuran 3 mb');
      fileImgPath.value = '';
      return false;
    } else if (fileName > 50) {
      alert('Foto yang di input invalid! nama foto terlalu panjang, maksimal berjumlah 50 karakter');
      return false;
    }

    // Validasi input checkbox
    for (let i = 0; i < checkboxArr.length; i++) {
      checkArr.push(checkboxArr[i].checked);
      if (checkboxArr[i].checked) {
        textCheckboxArr.push(checkboxArr[i].nextElementSibling.textContent.trim());
      }
    }

    if (!checkArr.includes(true)) {
      alert("Checkbox tidak boleh kosong!");
      return false;
    }

    // Gabungkan text dari checked checkbox dengan string
    checkboxTexts = textCheckboxArr.join(' & ');

    // Persiapan Object PREFIX Name
    const OBJ_PROP_PREFIX = 'timer',
      SOPS_TAB_ID_PREFIX = '_';

    // Membuat object dinamis
    if (typeof SOP_DYNAMIC_DATA == 'undefined') {
      SOP_DYNAMIC_DATA = {};
    }

    SOP_DYNAMIC_DATA.idObject = OBJ_PROP_PREFIX + id_user;
    SOP_DYNAMIC_DATA.idSopsTab = SOPS_TAB_ID_PREFIX + id_user;

    // Membuat object untuk menampung object Time dinamis
    if (typeof dynamicTimerObj == 'undefined') {
      dynamicTimerObj = {};
    }

    // Instatiate Object Timer Dinamis
    dynamicTimerObj[SOP_DYNAMIC_DATA.idObject] = new Timer(SOP_DYNAMIC_DATA.idSopsTab, formSopStarter);
    dynamicTimerObj[SOP_DYNAMIC_DATA.idObject].startTimer(totalSopTimeEst);

    // debug
    console.log(dynamicTimerObj, textCheckboxArr);


    $('.scotch-open').remove(); // Menghapus modal SOP
    // Meng-setting ulang button aksi SOP
    $(`#${SOP_DYNAMIC_DATA.idSopsTab} #startSopBtn`).prop('disabled', true);
    $(`#${SOP_DYNAMIC_DATA.idSopsTab} #stopSopBtn`).prop('disabled', false);

    // Meng-setting keterangan sop pada tab aktif
    $(`#${SOP_DYNAMIC_DATA.idSopsTab} #jenisPerawatan`).text(checkboxTexts);

    alert("Timer sop dimulai! selamat bekerja...");
    return false;
  } catch (e) {
    alert('Terjadi kesalahan pada program...\nPesan Error: ' + e);
    return false;
  }
}

function validateSopFinishingForm(id, context) {
  try {
    if (!confirm('Konfirmasi Penyelesaian SOP!')) { return false; }

    let el_sopFinishingForm = context[0].children['sopFormFinishing'],
      el_sopFinishingContainer = context;


    // Validasi input file
    let fileImgPath = el_sopFinishingForm.foto_bukti_struk;
    let fileImg = fileImgPath.files;
    let fileSize = Math.round((fileImg[0].size / 1024));
    let fileName = fileImg[0].name.length;
    let allowedExtensions = /(\.jpg|\.jpeg|\.png)$/i;

    if (!allowedExtensions.exec(fileImgPath.value)) {
      alert('Foto yang di input invalid! foto harus bertipe jpg/jpeg/png!');
      fileImgPath.value = '';
      return false;
    } else if (fileSize > 3072) {
      alert('Foto yang di input invalid! foto maksimal berukuran 3 mb');
      fileImgPath.value = '';
      return false;
    } else if (fileName > 50) {
      alert('Foto yang di input invalid! nama foto terlalu panjang, maksimal berjumlah 50 karakter');
      return false;
    }

    // Persiapan pemanggilan object dinamis
    const OBJ_PROP_PREFIX = 'timer', OBJ_PROP_SUFFIX = id;
    const DYNAMIC_OBJ_PROP = OBJ_PROP_PREFIX + OBJ_PROP_SUFFIX;

    dynamicTimerObj[DYNAMIC_OBJ_PROP.replace("_", "")].createFormDataObject(el_sopFinishingForm);

    // Mengahus element form finishing
    $(el_sopFinishingContainer).remove();

    // debug
    console.log(id, context);
    console.log(DYNAMIC_OBJ_PROP);
    return false;
  } catch (e) {
    alert('Terjadi kesalahan pada program...\nPesan Error: ' + e);
    return false;
  }
}

function stopSop(id) {
  if (!confirm('Waktu SOP sedang berjalan, Apa anda yakin untuk berhenti sekarang?')) { return false; }

  // Persiapan pemanggilan object dinamis
  const OBJ_PROP_PREFIX = 'timer', OBJ_PROP_SUFFIX = id;
  const DYNAMIC_OBJ_PROP = OBJ_PROP_PREFIX + OBJ_PROP_SUFFIX;

  dynamicTimerObj[DYNAMIC_OBJ_PROP].stopTimer();
}

function sopFinishing(id, sopResult) {
  let newContent, el_target = $(`#${id} .flex-container .flex-item`);

  // Meng-setting keterangan sop pada tab aktif
  $(`#${id} #jenisPerawatan`).text('');

  if (el_target == null) {
    return false;
  }

  if (sopResult) {
    newContent = `
      <label for="foto_bukti_struk">Upload foto: </label>
      <div class="input" style="width: 100%;"><input type="file" id="foto_bukti_struk" name="foto_bukti_struk" required></div> 
    `;
  } else {
    newContent = `
      <label for="foto_bukti_struk">Upload foto: </label>
      <div class="input" style="width: 100%;"><input type="file" id="foto_bukti_struk" name="foto_bukti_struk" required></div> 
      <label for="ket">Keterangan: </label>
      <div class="input" style="width: 100%;">
        <textarea name="keterangan" id="ket" style="width:60%;" cols="2" rows="5" minlength="0" maxlength="100" required></textarea>
      </div> 
    `;
  }

  newContent = `
    <div id="sop-finishing" class="flex-item">
      <form name="sopFormFinishing" id="sop-form-finishing" onsubmit="return validateSopFinishingForm($(this).parent().parent().parent().attr('id'), $(this).parent());">
        <div class="form-group">
          <h3>Penyelesaian SOP</h3>
          ${newContent}
        </div>  
        <div class="form-group">
          <input type="submit" value="Selesai" class="tombol edit" style="float: right;">
        </div>
      </form>
    </div>
  `;

  el_target.after(newContent);
}

// Timer Class
class Timer {
  #timer_id;
  #runningTime;
  #countup_timer;
  #formSopStarter;
  #formDataObj;

  #el_timer;
  #el_startBtn;
  #el_stopBtn;

  constructor(timer_id, context) {
    this.#timer_id = timer_id;

    if (this.#timer_id == null) {
      alert('Error On Timer Class: ID Tab Sop tidak ditemukan!');
    } else {
      this.#el_timer = $(`#${this.#timer_id} #waktuSop`);
      this.#el_startBtn = $(`#${this.#timer_id} #startSopBtn`);
      this.#el_stopBtn = $(`#${this.#timer_id} #stopSopBtn`);
      this.#formSopStarter = context;

      if (this.#el_timer == null) { alert('Error On Timer Class: ID Timer tidak ditemukan!'); }
      else if (this.#el_startBtn == null) { alert('Error On Timer Class: ID Start Timer Button tidak ditemukan!'); }
      else if (this.#el_stopBtn == null) { alert('Error On Timer Class: ID Stop Timer Button tidak ditemukan!'); }
      else if (this.#formSopStarter == null) { alert('Error On Timer Class: ID/Name Form Sop Starter tidak ditemukan!'); }
    }
  }

  startTimer(EstimationTime, starterTime = '00:00:00') {
    let sec = 0, min = 0, hrs = 0;

    // Set element target durasi
    $(this.#el_timer[0].children['targetDurasiSop']).text(EstimationTime);

    this.#countup_timer = setInterval(() => {
      sec = parseInt(sec);
      min = parseInt(min);
      hrs = parseInt(hrs);

      sec++;
      if (sec >= 60) {
        min++;
        sec = 0;
      }
      if (min >= 60) {
        hrs++;
        min = 0;
        sec = 0;
      }
      if (sec < 10 || sec == 0) {
        sec = '0' + sec;
      }
      if (min < 10 || min == 0) {
        min = '0' + min;
      }
      if (hrs < 10 || hrs == 0) {
        hrs = '0' + hrs;
      }

      $(this.#el_timer[0].children['durasiSopBerjalan']).text(`${hrs}:${min}:${sec}`);
      this.#runningTime = `${hrs}:${min}:${sec}`;

      if (this.#runningTime >= EstimationTime) {
        clearInterval(this.#countup_timer);
        alert("Waktu telah selesai!");
        $(this.#el_timer[0].children['durasiSopBerjalan']).text('00:00');
        $(this.#el_timer[0].children['targetDurasiSop']).text('00:00');
        this.#el_startBtn.prop('disabled', true);
        this.#el_stopBtn.prop('disabled', true);
        sopFinishing(this.#timer_id, true); // this is a global func
      }
    }, 1000);
  }

  createFormDataObject(secondForm) {
    this.#formDataObj = new FormData(this.#formSopStarter);
    this.#formDataObj.append('sop_time_result', this.#runningTime);
    if (secondForm == null) {
      alert('Error On Timer Class: method createFormDataObj bermasalah!');
    } else {
      let secondFormTmpObj = new FormData(secondForm);
      for (var pair of secondFormTmpObj.entries()) {
        this.#formDataObj.append(pair[0], pair[1]);
      }
      this.#insertSop(this.#formDataObj);
    }
  }

  #insertSop(formDataObj) {
    let idloadTable = this.#timer_id.replace("_", "");

    $.ajax({
      url: "request/sop_insert.php",
      method: "POST",
      data: formDataObj,
      processData: false,
      contentType: false,
      dataType: "json",
      success: (res) => {
        if (res.status) {
          loadSopTables([idloadTable]); // global function
          alert(res.message);

          this.#el_startBtn.prop('disabled', false);

          // debug
          console.log(res.data);
        }
      },
      error: function (res) {
        alert(`Terjadi kesalahan pada server!\n${res.message}`);
      }
    });
  }

  stopTimer() {
    let conf = confirm('Anda yakin akan menghentikan Timer?');
    if (conf == true) {
      clearInterval(this.#countup_timer);
      $(this.#el_timer[0].children['durasiSopBerjalan']).text('00:00');
      $(this.#el_timer[0].children['targetDurasiSop']).text('00:00');
      this.#el_startBtn.prop('disabled', true);
      this.#el_stopBtn.prop('disabled', true);
      sopFinishing(this.#timer_id, false); // this is a global func
    }
  }
}

function loadSopTables(id_users) {
  // debug
  console.log(`params - ${id_users.join(', ')}`);

  for (let i = 0; i < id_users.length; i++) {
    let url = "request/load_sop_table.php";
    let req = `id_user=${id_users[i]}`;

    $.ajax({
      url: url,
      method: "GET",
      data: req,
      processData: false,
      contentType: false,
      dataType: "json",
      cache: false,
      success: function (res) {
        if (res.status) {
          let el = $(`#_${id_users[i]} #sopTable`);
          el.html(res.html);
        }
      },
      error: function (res) {
        alert(`Terjadi kesalahan pada server!\n${res.message}`);
      }
    });
  }

  return 0;

  // let prefix = 'sopTable';

  // if (typeof sopTableContentObj == 'undefined') {
  //   sopTableContentObj = {};
  // }

  // sopTableContentObj[prefix + id_user] = function (id) {
  //   // $.ajaxSetup({ async: false });
  //   let url = "request/load_sop_table.php";
  //   let req = `id_user=${id}`;
  //   return $.ajax({
  //     // async: false,
  //     url: url,
  //     method: "GET",
  //     data: req,
  //     processData: false,
  //     contentType: false,
  //     dataType: "json",
  //     cache: false,
  //     success: function (res) {
  //       if (res.status) {
  //         let el = $(`#_${id} #sopTable`);
  //         el.html(res.html);
  //         console.log(el, res.html); // debug

  //       }
  //     },
  //     error: function (res) {
  //       alert(`Terjadi kesalahan pada server!\n${res.message}`);
  //     }
  //   });
  // }

  // sopTableContentObj[prefix + id_user](id_user);
  // $.ajaxSetup({ async: true });
}

// function readURL(input) {
//   if (input.files && input.files[0]) {
//     var reader = new FileReader();

//     reader.onload = function (e) {
//       $('#imgPreview').attr('src', e.target.result);
//       $('#note').text(e.target.result);
//       console.log(e);
//     }

//     reader.readAsDataURL(input.files[0]); // convert to base64 string
//   }
// }

// $("#fp").change(function () {
//   readURL(this);
//   form1 = $('form[name="myForm"]')[0];
//   form2 = $('form[name="myForm2"]')[0];
//   let formData1 = new FormData(form1);
//   let formData2 = new FormData(form2);
//   console.log(form1);
//   console.log(formData1);
//   for (var pair of formData2.entries()) {
//     formData1.append(pair[0], pair[1]);
//     // console.log(pair[0] + ', ' + pair[1]);
//   }
//   $.ajax({
//     url: "request/test-file-upload.php",
//     method: "POST",
//     data: formData1,
//     processData: false,
//     contentType: false,
//     dataType: "json",
//     success: function (res) {
//       if (res.status) {
//         console.log(res.data);
//       }
//     },
//     error: function () {
//       alert("Terjadi kesalahan!");
//     }
//   });
// });
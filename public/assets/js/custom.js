
$(document).ready(function(){
    let passwordInput = document.getElementById('txtPassword'),
      toggle = document.getElementById('btnToggle'),
      icon =  document.getElementById('eyeIcon');

  function togglePassword() {
    if (passwordInput.type === 'password') {
      passwordInput.type = 'text';
      icon.classList.add("fa-eye-slash");
    } else {
      passwordInput.type = 'password';
      icon.classList.remove("fa-eye-slash");
    }
  }
  toggle.addEventListener('click', togglePassword, false);
  passwordInput.addEventListener('keyup', checkInput, false);

  });

// 
$(document).ready(function () {
  // Toggle submenu on click
  $('.nav-right > li > a').click(function (e) {
    var submenu = $(this).next('.nav-right__sub');

    // If submenu exists, prevent default link behavior
    if (submenu.length) {
      e.preventDefault();

      // Toggle submenu visibility
      submenu.slideToggle(200);

      // Close other open submenus (accordion effect)
      $('.nav-right__sub').not(submenu).slideUp(200);
    }

    // 👉 Add active class to the parent <li>, remove from siblings
    $(this).parent('li').addClass('active').siblings().removeClass('active');
  });
});

// Handle submenu item clicks
$('.nav-right__sub li a').click(function () {
  $('.nav-right__sub li').removeClass('active'); // remove from all
  $(this).parent('li').addClass('active'); // add to clicked
});



$(".user-dropdown__image").click(function () {
    $(this).toggleClass("nav-close");
    $(".user-dropdown__nav").slideToggle();
});

const checkbox = document.getElementById("checkbox")
checkbox.addEventListener("change", () => {
  document.body.classList.toggle("dark")
})



// 

document.getElementById('fileUpload').addEventListener('change', function () {
  const file = this.files[0];
  const previewImage = document.getElementById('previewImage');
  const uploadText = document.getElementById('uploadText');
  const fileNameText = document.getElementById('fileName');

  if (file && file.type.startsWith('image/')) {
    const reader = new FileReader();
    reader.onload = function (e) {
      previewImage.src = e.target.result;
      uploadText.textContent = '';
      fileNameText.textContent = file.name;
    };
    reader.readAsDataURL(file);
  } else {
    previewImage.src = 'https://img.icons8.com/ios/100/image--v1.png';
    uploadText.textContent = 'Choose file';
    fileNameText.textContent = 'Please select a valid image file.';
  }
});




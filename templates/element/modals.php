<!-- top navigation -->
<div class="top_nav">
  <div class="nav_menu">
      <div class="nav toggle">
        <a id="menu_toggle"><i class="fa fa-bars"></i></a>
      </div>
<nav class="nav navbar-nav">

      <ul class=" navbar-right">
        <li class="nav-item dropdown open" style="padding-left: 15px;">
          <a href="javascript:;" class="user-profile dropdown-toggle" aria-haspopup="true" id="navbarDropdown" data-toggle="dropdown" aria-expanded="false">
           

          </a>
          <div class="dropdown-menu dropdown-usermenu pull-right" aria-labelledby="navbarDropdown">

            <?php if($currentUser['Role']['code'] == 'Student'){ ?>

              <a class="dropdown-item"  href="#/profile/student-profile/view-profile/<?php echo $currentUser['Student']['id'] ?>"> Profile</a>

            <?php } else {?>

              <a class="dropdown-item"  href="#/users/edit/<?php echo $currentUser['User']['id'] ?>"> Profile</a>

            <?php }  ?>

            <a class="dropdown-item" data-toggle="modal" data-target="#themeModal">

             Theme Editor

            </a>
            <a class="dropdown-item" href="<?= $this->Url->build('/logout') ?>">
              <i class="fa fa-sign-out pull-right"></i> Log Out
            </a>
            <!-- <a href="<?= $this->Url->build('/logout') ?>"><span>Logout</span></a> -->
           
            
          </div>
        </li>

      
      </ul>
    </nav>
  </div>
</div>
<!-- /top navigation -->

<div class="modal fade" id="themeModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Theme Editor</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="form-group row pt-3">
        <div class="color-selector mx-2">
          <label for="color-picker">Select Sidebar Color:</label>
          <input type="color" id="color-picker">
        </div>

        <div id="font-color-picker mx-2">
          <label for="font-color">Choose a font color:</label>
          <input type="color" id="font-color">
        </div>
      </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-info" data-dismiss="modal" onclick="defaultColor()">Reset To Default</button>
      </div>
    </div>
  </div>
</div>

<script type="text/javascript">document.addEventListener('DOMContentLoaded', function () {

  const colorPicker = document.getElementById('color-picker');
  const savedColor = localStorage.getItem('sidebarColor');


  if (savedColor) {
    const lighterColor = lightenColor(savedColor, 10);
    const lightersColor = lightenColor(savedColor, 40);
    document.getElementById('sidebar').style.backgroundColor = savedColor;
    document.getElementById('sidebarName').style.backgroundColor = savedColor;
    document.getElementById('sidebarLeft').style.backgroundColor = savedColor;
    document.querySelectorAll('.bg-change ul').forEach((element) => {
      element.style.backgroundColor = savedColor;
    });
    document.querySelectorAll('.nav.side-menu > li > a').forEach((element) => {
      element.style.setProperty('--custom-color', `${lighterColor}`);
      element.style.setProperty('--hover-color', `${lightersColor}`);
    });

    colorPicker.value = savedColor;
  }

  colorPicker.addEventListener('change', function () {
    const selectedColor = colorPicker.value;
    const selectedLighterColor = lightenColor(selectedColor, 10);
    const selectedLightersColor = lightenColor(selectedColor, 40);
    document.getElementById('sidebar').style.backgroundColor = selectedColor;
    document.getElementById('sidebarName').style.backgroundColor = selectedColor;
    document.getElementById('sidebarLeft').style.backgroundColor = selectedColor;
    document.querySelectorAll('.bg-change ul').forEach((element) => {
      element.style.backgroundColor = selectedColor;
    });

    document.querySelectorAll('.nav.side-menu > li > a').forEach((element) => {
      element.style.setProperty('--custom-color', `${selectedLighterColor}`);
      element.style.setProperty('--hover-color', `${selectedLightersColor}`);
    });

    localStorage.setItem('sidebarColor', selectedColor);
  });
});

document.addEventListener('DOMContentLoaded', function () {
  const fontColorPicker = document.getElementById('font-color');

  const savedFontColor = localStorage.getItem('selectedFontColor');
  if (savedFontColor) {
    document.querySelectorAll('.font-change span').forEach((element) => {
      element.style.color = savedFontColor;
    });
    document.querySelectorAll('.font-change p').forEach((element) => {
      element.style.color = savedFontColor;
    });
    document.querySelectorAll('.font-change li').forEach((element) => {
      element.style.color = savedFontColor;
    });
    document.querySelectorAll('.font-change a').forEach((element) => {
      element.style.color = savedFontColor;
    });


    fontColorPicker.value = savedFontColor;
  }

  // Add an event listener to update the font color when the font color picker changes
  fontColorPicker.addEventListener('change', function () {
    const selectedFontColor = fontColorPicker.value;
    document.querySelectorAll('.font-change span').forEach((element) => {
      element.style.color = selectedFontColor;
    });
    document.querySelectorAll('.font-change p').forEach((element) => {
      element.style.color = selectedFontColor;
    });
    document.querySelectorAll('.font-change li').forEach((element) => {
      element.style.color = selectedFontColor;
    });
    document.querySelectorAll('.font-change a').forEach((element) => {
      element.style.color = selectedFontColor;
    });

    localStorage.setItem('selectedFontColor', selectedFontColor);
  });
});

function defaultColor() {

    const defaultSidebar = '#2A3F54';
    document.getElementById('sidebar').style.backgroundColor = defaultSidebar;
    document.getElementById('sidebarName').style.backgroundColor = defaultSidebar;
    document.getElementById('sidebarLeft').style.backgroundColor = defaultSidebar;
    document.querySelectorAll('.bg-change ul').forEach((element) => {
      element.style.backgroundColor = defaultSidebar;
    });

    document.querySelectorAll('.nav.side-menu > li > a').forEach((element) => {
      element.style.setProperty('--custom-color', 'linear-gradient(#334556, #2C4257),#2A3F54');
      element.style.setProperty('--hover-color', 'white');
    });

    localStorage.setItem('sidebarColor', defaultSidebar);

  const defaultFont = 'rgba(255,255,255,0.80)';
    document.querySelectorAll('.font-change span').forEach((element) => {
      element.style.color = defaultFont;
    });
    document.querySelectorAll('.font-change p').forEach((element) => {
      element.style.color = defaultFont;
    });
    document.querySelectorAll('.font-change li').forEach((element) => {
      element.style.color = defaultFont;
    });
    document.querySelectorAll('.font-change a').forEach((element) => {
      element.style.color = defaultFont;
    });

    localStorage.setItem('selectedFontColor', defaultFont);


}




function lightenColor(hex, percent) {
  // Parse the hex color to RGB values
  const r = parseInt(hex.slice(1, 3), 16);
  const g = parseInt(hex.slice(3, 5), 16);
  const b = parseInt(hex.slice(5, 7), 16);

  // Convert RGB to HSL
  let hsl = rgbToHsl(r, g, b);

  // Increase the lightness value by the given percent
  hsl[2] += percent;

  // Ensure the lightness value stays within the valid range [0, 100]
  hsl[2] = Math.min(100, Math.max(0, hsl[2]));

  // Convert the modified HSL back to RGB
  const rgb = hslToRgb(hsl[0], hsl[1], hsl[2]);

  // Convert the modified RGB back to hexadecimal
  const modifiedHex = rgbToHex(rgb[0], rgb[1], rgb[2]);

  return modifiedHex;
}

// Function to convert RGB to HSL
function rgbToHsl(r, g, b) {
  r /= 255;
  g /= 255;
  b /= 255;

  const max = Math.max(r, g, b);
  const min = Math.min(r, g, b);
  let h, s, l = (max + min) / 2;

  if (max === min) {
    h = s = 0; // achromatic
  } else {
    const d = max - min;
    s = l > 0.5 ? d / (2 - max - min) : d / (max + min);
    switch (max) {
      case r: h = (g - b) / d + (g < b ? 6 : 0); break;
      case g: h = (b - r) / d + 2; break;
      case b: h = (r - g) / d + 4; break;
    }
    h /= 6;
  }

  return [h * 360, s * 100, l * 100];
}

// Function to convert HSL to RGB
function hslToRgb(h, s, l) {
  h /= 360;
  s /= 100;
  l /= 100;
  let r, g, b;

  if (s === 0) {
    r = g = b = l; // achromatic
  } else {
    const hue2rgb = (p, q, t) => {
      if (t < 0) t += 1;
      if (t > 1) t -= 1;
      if (t < 1 / 6) return p + (q - p) * 6 * t;
      if (t < 1 / 2) return q;
      if (t < 2 / 3) return p + (q - p) * (2 / 3 - t) * 6;
      return p;
    };
    const q = l < 0.5 ? l * (1 + s) : l + s - l * s;
    const p = 2 * l - q;
    r = hue2rgb(p, q, h + 1 / 3);
    g = hue2rgb(p, q, h);
    b = hue2rgb(p, q, h - 1 / 3);
  }

  return [Math.round(r * 255), Math.round(g * 255), Math.round(b * 255)];
}

// Function to convert RGB to hexadecimal
function rgbToHex(r, g, b) {
  return `#${r.toString(16).padStart(2, '0')}${g.toString(16).padStart(2, '0')}${b.toString(16).padStart(2, '0')}`;
}


</script>
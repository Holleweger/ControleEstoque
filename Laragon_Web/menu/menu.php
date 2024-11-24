<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="UTF-8">
    <title> InventoryKeeper </title>
    <link rel="stylesheet" href="http://localhost/menu/menu.scss">
    <!-- Boxiocns CDN Link -->
    <link rel="icon" href="http://localhost/menu/icon.png" type="image/x-icon" />
    <link href='https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css' rel='stylesheet'>
     <meta name="viewport" content="width=device-width, initial-scale=1.0">
   </head>
<body>
  <div class="sidebar close">
    <div class="logo-details">
      <img src="http://localhost/menu/icon.png" width="50vw" style="margin-left: 18%">
      <span class="logo_name">Inventory</span>
    </div>
    <ul class="nav-links">
      <li>
        <a href="http://localhost/home">
          <i class='bx bx-building-house'></i>
          <span class="link_name">Home</span>
        </a>
        <ul class="sub-menu blank">
          <li><a class="link_name" href="http://localhost/home">Home</a></li>
        </ul>
      </li>
      <li>
        <div class="iocn-link">
          <a href="#">
          <i class='bx bx-grid'></i>
            <span class="link_name">Estoque</span>
          </a>
          <i class='bx bxs-chevron-down arrow' ></i>
        </div>
        <ul class="sub-menu">
          <li><a class="link_name" href="#">Armazenamento</a></li>
          <li><a href="http://localhost/cadastro_gondola/cadastro_gondola_list/cadastro_gondola_list.php#">Gôndola</a></li>
          <li><a href="http://localhost/cadastro_gaveta/cadastro_gaveta_list/cadastro_gaveta_list.php#">Gaveta</a></li>
        </ul>
      </li>
      <li>
        <div class="iocn-link">
          <a href="#">
          <i class='bx bx-package'></i>
            <span class="link_name">Produtos</span>
          </a>
          <i class='bx bxs-chevron-down arrow' ></i>
        </div>
        <ul class="sub-menu">
          <li><a class="link_name" href="#">Produtos</a></li>
          <li><a href="http://localhost/cadastro_produto/cadastro_produto_list/cadastro_produto_list.php#">Produto</a></li>
          <li><a href="http://localhost/cadastro_produto_gaveta/cadastro_produto_gaveta_list/cadastro_produto_gaveta_list.php#">Inventário</a></li>
        </ul>
      </li>
      <li>
        <a href="#">
          <i class='bx bx-cog' ></i>
          <span class="link_name">Configurações</span>
        </a>
        <ul class="sub-menu blank">
          <li><a class="link_name" href="#">Setting</a></li>
        </ul>
      </li>
      <li>
    <div class="profile-details">
      <div class="profile-content">
      </div>
      <div class="name-job">
        <div class="profile_name">Wagner</div>
        <div class="job">Desenvolvedor</div>
      </div>
      <a href="http://localhost"><i class='bx bx-log-out' ></i></a>
    </div>
  </li>
</ul>
  </div>
  <section class="home-section">
    <div class="home-content">
      <i class='bx bx-menu' ></i>
    </div>
  </section>
  <script>
  let arrow = document.querySelectorAll(".arrow");
  for (var i = 0; i < arrow.length; i++) {
    arrow[i].addEventListener("click", (e)=>{
   let arrowParent = e.target.parentElement.parentElement;//selecting main parent of arrow
   arrowParent.classList.toggle("showMenu");
    });
  }
  let sidebar = document.querySelector(".sidebar");
  let sidebarBtn = document.querySelector(".bx-menu");
  console.log(sidebarBtn);
  sidebarBtn.addEventListener("click", ()=>{
    sidebar.classList.toggle("close");
  });
  </script>
</body>
</html>

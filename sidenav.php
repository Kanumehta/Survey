

<div class="sidebar">
      <div class="logo_content">
        <div class="logo">
        <img src="images/footprint.png" width="150px">
      </div>
      <i class='bx bx-menu' id="btn"></i>
      <!-- <img src="images/fp.jpg" width="50px; height= 50px;"> -->
    </div>
    <div>
    <ul class="nav_list">
      <li>
        <a href="main.php">
        <i class='bx bx-grid-alt'></i>
        <span class="link_names">Dashboard</span>
        </a>
        <span class="srch">Dashboard</span>
      </li>

      <li>
        <a href="newuser.php">
        <i class='bx bx-user-plus'></i>
        <span class="link_names">New User</span>
        </a>
        <span class="srch">New User</span>
      </li>

      <li>
        <a href="userlist.php">
        <i class='bx bxs-user-detail'></i>
        <span class="link_names">User List</span>
        </a>
        <span class="srch">User List</span>
      </li>

      <li>
        <a href="srvypage.php">
        <i class='bx bx-plus'></i>
        <span class="link_names">New Survey</span>
        </a> -->
        <span class="srch">New Survey</span>
      </li>

      <li>
        <a href="srvylist.php">
        <i class='bx bx-list-ul' ></i>
        <span class="link_names">Survey List</span>
        </a> -->
        <span class="srch">Survey List</span>
        </li>
      
      <!-- <li>
        <a href="report.php">
        <i class='bx bxs-report'></i>
        <span class="link_names">Report</span>
        </a>
        <span class="srch">Report</span>
      </li> -->
    </ul>
</div>




   <script>
      let btn = document.querySelector("#btn");
      let sidebar = document.querySelector(".sidebar");
      let searchBtn = document.querySelector(".bx-search");

      btn.onclick = function(){
        sidebar.classList.toggle("active");
      }

      searchBtn.onclick = function(){
        sidebar.classList.toggle("active");
      }
    </script>


</body>
</html>
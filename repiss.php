<?php
require_once 'includes/config_session.inc.php';
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <title>Add Content</title>
        <link rel="icon" type="image/png" href="assets/logo.png" />
        <meta name="description" content="" />
        <meta name="viewport" content="width=device-width, initial-scale=1" />
        <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css"
        rel="stylesheet"
        integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9"
        crossorigin="anonymous"
        />
        <link
        rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"
        />
        <link
        rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css"
        />
        <link rel="stylesheet" href="style.css" />
        <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet"/>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
        <script>
          document.addEventListener("DOMContentLoaded", function () {
              document.querySelector('input[name="ulimage"]').addEventListener("change", function () {
                  var filename = this.value.split('\\').pop(); // 获取文件名
                  var fileSize = this.files[0].size; // 获取文件大小
                  var maxSize = 4 * 1024 * 1024; // 4MB

                  if (filename.length > 250) { // 如果文件名超过250个字符
                      alert("File name exceeds maximum length of 250 characters.");
                      this.value = ""; // 清空文件选择框
                  } else if (fileSize > maxSize) { // 如果文件大小超过4MB
                      alert("File size exceeds maximum limit of 4MB.");
                      this.value = ""; // 清空文件选择框
                  }
              });
            });
          </script>
    </head>

    <?php
    include 'includes/headers/header_merchant.inc.php';
    ?>

    <body>
    <div class="container-fluid pb-5">
        <div class="row">
            <nav class="col-md-2 d-md-block side-menu p-5" style="text-align:center">
                <h5 class="text-center"><?php echo $_SESSION["user_username"] ?>'s Dashboard</h5>
                <hr class="my-3">
                <a href="activityques.php">Add Activity</a>
                <a href="profile.php">Profile</a>
                <a href="searchhistory.php">History</a>
                <a href="friends.php">Friends</a>
                <a href = "Recommendation.php">Recommendation</a>
                <a href="educationalcontent.php">Education Content</a>

                    <!-- Add more links as needed -->
            </nav>

            <div class="col-md-8 pt-5">
                    
                    <form action="connect.php" method="POST" enctype="multipart/form-data">
                        <h2>Add Education Content</h2>

                        <div class="mb-3">
                          <label for="" >Upload Image</label>
                          <input type="file" class="form-control"  name="ulimage" accept="image/*,video/*" required>
                        </div>

                        <div class="mb-3">
                          <label for="" >Title</label>
                          <input type="text" class="form-control"  name="ultitle" placeholder="What's the title?" required maxlength="50">
                        </div>

                        <div class="mb-3">
                          <label for="" >Description</label>
                          <input type="text" class="form-control"  name="uldescription" placeholder="Some description?" required maxlength="500">
                        </div>

                        <div class="mb-3">
                          <label for="ulurl" >URL</label>
                          <input type="url" class="form-control"  name="ulurl" placeholder="Please upload the link here" >
                        </div>

                        <div class="mb-3">
                          <label for="" >Category</label>
                          <select name="category" class="form-control" required>
                            <option value="" disabled selected hidden >Please select one category here</option>
                            <option value="transportation" name="transportation">Transportation</option>
                            <option value="energy" name="energy">Energy Usage</option>
                            <option value="diet" name="diet">Diet</option>
                            <option value="waste" name="waste">Waste Management</option>
                            <option value="miscellaneous" name="miscellaneous">Miscellaneous</option>
                            
                          </select>
                        </div>

                        <button type="reset" class="btn btn-primary m-1">Reset</button><br>

                        <button type="submit" class="btn btn-primary m-1" name="upload">Upload</button>
                    </form>

                    <!--fetch data-->

                    <div class="contaioner">

                      <table class="table">
                        <thead>
                          <tr>
                            <th scope="col">ID</th>
                            <th scope="col">Category</th>
                            <th scope="col">Image</th>
                            <th scope="col">Title</th>
                            <th scope="col">Describtion</th>
                            <th scope="col">URL</th>
                            <th scope="col">delete</th>
                            <th scope="col">Update</th>
                          </tr>
                        </thead>
                        <tbody>
                        
                          <?php
                            include 'config.php';
                            $pic = mysqli_query($con,"SELECT * FROM `uploadcontent`");
                            while($row = mysqli_fetch_array($pic)){
                            echo "
                              <tr>
                                <td>$row[id]</td>
                                <td>$row[Category]</td>
                                <td><img src='$row[Image]' width ='100px' height ='70px'></td>
                                <td>$row[Title]</td>
                                <td>$row[Description]</td>
                                <td>$row[URL]</td>
                                <td><a href='delete.php? Id=$row[id]' class = 'btn btn-danger'>Delete</a></td>
                                <td><a href='update.php? Id=$row[id]' class = 'btn btn-danger'>Update</a></td>
                              </tr>
                              ";
                            }

                          ?>

                        </tbody>
                      </table>
                    </div>
            </div>
          </div>
        </div>
    </div>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script
        src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-HwwvtgBNo3bZJJLYd8oVXjrBZt8cqVSpeBNS5n7C8IVInixGAoxmnlMuBnhbgrkm"
        crossorigin="anonymous"
    >
    </script>
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script src="script.js"></script>
    
    <!-- JavaScript -->
    
  
  </body>


</html>



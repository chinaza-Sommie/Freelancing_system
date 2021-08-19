<?php ?>

<!DOCTYPE html>
<html>
<head>
    <title> blog panel</title>
    <link rel="stylesheet" type="text/css" href="../my_Profile/bootstrap2/bootstrap.css">
    <link rel="stylesheet" type="text/css" href="blogpanel.css">
</head>
<body>

    <div class="text-center mytitlebanner">life itself</div>

    <div class="coverageforsideNmain">
        <div id="mySidebar" class="text-center mySidebarClass">
            <div class="text-right pr-4"><span class="mybad" onclick="closeMe()">&times</span></div>
                <!-- for my links -->

                <p id="addMe" onclick="activeGiveAway()">Add Post</p>   <!-- this is where i can add posts to any section at all -->
                <p >My Posts</p> <!-- this is where all my posts would stack -->
                <p onclick='pageNavigation(event,"Rating")'>Ratings</p> <!-- this would have post how ,any veiwed and likes and comments -->
                <p>Performancee</p> <!-- this would have most viewed post -->
                <p> Comments</p> <!-- this is where comments would be displayed -->
                <p>Earnings</p> <!-- this is where my earnings would be displayed -->
        </div>

        <div id="main">
            <div class="pl-4" id="openSlide"><span onclick="openSide()">openSide</span></div>
            
            <div class="containhide p-5 firstPOst" id="NewPost">
                <form class="container">
                    <div class="row">
                        <div class="col-md-6">
                            <p><em>Post Topic:</em></p>
                            <div class="input-group">
                                <input type="text" name="">
                            </div>
                        </div>

                        <div class="col-md-6">
                            <p><em>Choose Your Post Category:</em></p>
                            <div class="input-group">
      
                                <select class="postCategory" name="workCategory">
                                      <!-- <option>choose </option> -->
                                      <option name="web_development">web development</option>
                                        <option name="Android_development">Android development</option>
                                        <option name="Web_design"> Web design</option>
                                </select>            
                            </div>
                        </div>
                    </div>
                    <div class="NewPostText">
                        <p class="mt-3"><em>Add Your post:</em></p>
                        <hr>

                        <p class="text-left"><em>first Paragraph:</em></p>
                        <textarea placeholder="add a new post..." rows="10" cols="30" ></textarea>
                        
                    </div>
                    <div class="row mt-3">
                        <div class="col-md-6">
                            <p class="text-left"><em>second Paragraph:</em></p>
                            <div class="input-group">
                                       <textarea rows="2" cols="30" placeholder="Add the Responsibilities of this position" name="jobrespbility1" style="width: 100%" class="p-3"></textarea>
                                    </div>  
                        </div>

                        <div class="col-md-6">
                            <p class="text-left"><em>third Paragraph:</em></p>
                            <div class="input-group">
                                <textarea rows="2" cols="30" placeholder="Add the Responsibilities of this position" name="jobrespbility1" style="width: 100%" class="p-3"></textarea>
                            </div>  
                        </div>
                    </div>

                    <div class="mt-4"><!-- this indicates a place to add your images -->
                        <p ><em>Add Your Images</em></p>
                        <hr>
                    </div>

                            <!-- FIRST ROW OF MY IMAGES -->
                    <div class="row mt-4">
                        <div class="col-md-4">
                            <div class="form-group">
                                <div class="custom-file">
                                    <input class="custom-file-input" type="File" name="Image2" value="" id="imageselect">
                                    <label for="imageselect" class="custom-file-label">Select Image</label>
                                </div>

                                </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <div class="custom-file">
                                    <input class="custom-file-input" type="File" name="Image2" value="" id="imageselect">
                                    <label for="imageselect" class="custom-file-label">Select Image</label>
                                </div>

                                </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <div class="custom-file">
                                    <input class="custom-file-input" type="File" name="Image2" value="" id="imageselect">
                                    <label for="imageselect" class="custom-file-label">Select Image</label>
                                </div>

                                </div>
                        </div>
                    </div>
                            <!-- SECOND ROW OF MY IMAGE  -->
                    <div class="row mt-4">
                        <div class="col-md-4">
                            <div class="form-group">
                                <div class="custom-file">
                                    <input class="custom-file-input" type="File" name="Image2" value="" id="imageselect">
                                    <label for="imageselect" class="custom-file-label">Select Image</label>
                                </div>

                                </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <div class="custom-file">
                                    <input class="custom-file-input" type="File" name="Image2" value="" id="imageselect">
                                    <label for="imageselect" class="custom-file-label">Select Image</label>
                                </div>

                                </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <div class="custom-file">
                                    <input class="custom-file-input" type="File" name="Image2" value="" id="imageselect">
                                    <label for="imageselect" class="custom-file-label">Select Image</label>
                                </div>

                                </div>
                        </div>
                    </div>

                    <div>
                        <input type="submit" name="SubmitNewPost" value="Publish">
                    </div>
                </form>
            </div>


            <!-- rating tab -->
            <div class="containhide" id="Rating">
                <div style="border: 1px solid red;">
                    <h1> This is my rating tab</h1>
                </div>
            </div>
        </div>
    </div>


    <script>

        document.getElementById('openSlide').style.display = "none";
        // var screenWidth = window.innerWidth;
        // if(screenWidth <= 700){
        //  document.getElementById('main').classList.toggle('mySpace');
        //  console.log(screenWidth);
        // }
        function closeMe(){
            document.getElementById('mySidebar').style.width = "0";
            document.getElementById('main').style.width = "100%";
            document.getElementById('openSlide').style.display = "block";

        }

        function openSide(){
            document.getElementById('mySidebar').style.width = "20%";
            document.getElementById('openSlide').style.display = "none";
        }

            // this adds an underline to my sidebar p tags
        function activeGiveAway(){
            document.getElementById('addMe').innerHTML= "this works";
            var me = myActive.classList.add('activeMe');
            // closeMe();
        }


        // the code below is used to hide the tab content of a particular tab and display the other
        function pageNavigation(e, tabId){
            var i, containhide;

             containhide = document.getElementsByClassName('containhide');
            for(i=0; i<containhide.length; i++){
                containhide[i].style.display = "none";
            }

            document.getElementById(tabId).style.display = "block";
        }

        window.onload=function(){
            pageNavigation(event, 'NewPost');
        }
    </script>
</body>
</html>
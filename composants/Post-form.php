<div id='textContent' class="post-creation">
    <form action="./create_post.php" method="post">
        <input type="text" name="title" class="inputTitle" placeholder="Post Title" required>
        <textarea class="post-textarea" name="content" rows="4" placeholder="Write your post..." required></textarea>
        <input type="hidden" name="forum_id" id="selectedForumId">
        <button class="btn-submit" type="submit">Post</button>
    </form>
</div>
<!-- Post Textuel et images -->
<div id="imageVideoContent" style="display: none;">
    <form id="uploadForm" action="./upload.php" method="post" enctype="multipart/form-data">
        <textarea class="post-textarea" name="description" placeholder="Description..."></textarea>
        <input type="file" id="fileToUpload" name="fileToUpload" accept=".png, .mp4">
        <button type="submit" name="submit">Upload</button>
    </form>
</div>
<style>
    textarea {
        resize: none;
    }
</style>

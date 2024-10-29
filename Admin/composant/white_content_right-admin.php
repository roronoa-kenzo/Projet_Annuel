
<div class="white-content-secondary">

    <h3>Parametre</h3>

    <form method="post" action="./composant/OptionUser.php">
        <ul>
            <button type="submit" name="home" class="btn-menu" value="home">Profile User</button>
        </ul>
        <ul>
            <button type="submit" name="PostUser" class="btn-menu" value="PostUser">Posts User</button>
        </ul>
        <ul>
            <button type="submit" name="CommentUser" class="btn-menu" value="CommentUser">Comments User</button>
        </ul>
        <ul>
            <button type="submit" name="admin" class="btn-menu" value="admin"><?= $user['is_admin'] ? 'Non Admin' : 'Admin' ?></button>
        </ul>
        <ul>
            <button type="submit" name="banni" class="btn-menu" value="banni"><?= $user['is_banned'] ? 'Débanne' : 'Ban' ?></button>
        </ul>
        <ul>
            <button type="submit" name="delete" class="btn-menu" value="delete">Remove user</button>
        </ul>
    </form>
</div>

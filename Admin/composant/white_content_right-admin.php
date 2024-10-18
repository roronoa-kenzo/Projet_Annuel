
<div class="white-content-secondary">

    <h3>Parametre</h3>

    <form method="post" action="./composant/OptionUser.php">
        <ul>
            <button type="submit" name="home" value="home">Profile User</button>
        </ul>
        <ul>
            <button type="submit" name="PostUser" value="PostUser">Posts User</button>
        </ul>
        <ul>
            <button type="submit" name="CommentUser" value="CommentUser">Comments User</button>
        </ul>
        <ul>
            <button type="submit" name="admin" value="admin"><?= $user['is_admin'] ? 'Non Admin' : 'Admin' ?></button>
        </ul>
        <ul>
            <button type="submit" name="banni" value="banni"><?= $user['is_banned'] ? 'Débanne' : 'Ban' ?></button>
        </ul>
        <ul>
            <button type="submit" name="delete" value="delete">Remove user</button>
        </ul>
    </form>
</div>


<div class="white-content-secondary">

    <h3>Parametre</h3>

    <form method="post" action="./composant/updateReport.php">
        <ul>
            <button type="submit" name="UserReport" class="btn-menu" value="UserReport">Profile User</button>
        </ul>
        <ul>
            <button type="submit" name="Accuser" class="btn-menu" value="Accuser">L'accuser</button>
        </ul>
        <ul>
            <button type="submit" name="RemoveContent" class="btn-menu" value="RemoveContent">Suprimer Forum Post comment</button>
        </ul>
        <input type="hidden" name="report_id" id="report_id" value="<?= $report['report_id'] ?>">                    

    </form>
</div>

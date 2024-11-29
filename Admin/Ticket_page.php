<?php require_once './composant/admin_check.php'; ?>
<?php include './../composants/header.php'; ?>
<?php include './composant/database.php'; ?>
<?php include './composant/sessionStart.php'; ?>

<body>
    <?php include './../composants/navbar.php'; ?>
    <main class="container">
        <div class="black-frame">
            <h1>All users</h1>
        </div>
        <div class="main-index-admin">
            <?php include './composant/white_content_left-admin.php'; ?>
            <div class="white-content-admin">

                <div class="post-container-admin">
                    <div class="iceberg-select">
                    </div>
                </div>

                <div class="users-list" id="usersList">

                </div>
                <script>
                    function ticketguery() {
                        fetch('./composant/ticket_guery.php')
                            .then(response => response.json())
                            .then(tickets => {
                                // Vérifiez si une erreur est retournée
                                if (tickets.error) {
                                    console.error('Erreur:', tickets.error);
                                    return;
                                }

                                // Afficher les tickets
                                tickets.forEach(ticket => {

                                    let usersList = document.getElementById('usersList');

                                    let div_container = document.createElement('div');
                                    div_container.classList.add('post-container-admin');
                                    usersList.appendChild(div_container);

                                    let href_tickets = document.createElement('a');
                                    href_tickets.setAttribute('href', `./Ticket_details.php?ticket=${ticket.id}`);
                                    href_tickets.classList.add('userLien');
                                    div_container.appendChild(href_tickets);

                                    let p_tilte = document.createElement('p');
                                    p_tilte.classList.add('username');
                                    p_tilte.appendChild(document.createTextNode("Titre du ticket:"));
                                    p_tilte.appendChild(document.createElement('br'));
                                    p_tilte.appendChild(document.createTextNode(ticket.title));
                                    document.body.appendChild(p_tilte);
                                    href_tickets.appendChild(p_tilte);

                                    let p_description = document.createElement('p');
                                    p_description.classList.add('username');
                                    p_description.appendChild(document.createTextNode("Contenue de la demande :"));
                                    p_description.appendChild(document.createElement('br'));
                                    p_description.appendChild(document.createTextNode(ticket.description));
                                    document.body.appendChild(p_description);
                                    href_tickets.appendChild(p_description);


                                    let p_mail = document.createElement('p');
                                    p_mail.classList.add('username');
                                    p_mail.appendChild(document.createTextNode("Mail du demandeur :"));
                                    p_mail.appendChild(document.createElement('br'));
                                    p_mail.appendChild(document.createTextNode(ticket.email));
                                    document.body.appendChild(p_mail);
                                    href_tickets.appendChild(p_mail);


                                    let p_priority = document.createElement('p');
                                    p_priority.classList.add('username');
                                    p_priority.appendChild(document.createTextNode("Prioriter de la demander :"));
                                    p_priority.appendChild(document.createElement('br'));
                                    p_priority.appendChild(document.createTextNode(ticket.priority));
                                    document.body.appendChild(p_priority);
                                    href_tickets.appendChild(p_priority);

                                    if (ticket.priority == "Critical") {
                                        p_priority.setAttribute('style', `color :red;`);
                                    }else if(ticket.priority == "High"){
                                        p_priority.setAttribute('style', `color :#fb5607;`);
                                    }else if(ticket.priority == "Medium"){
                                        p_priority.setAttribute('style', `color :#fcbf49;`);
                                    }else if(ticket.priority == "Low"){
                                        p_priority.setAttribute('style', `color :#90be6d;`);
                                    }

                                    let p_status = document.createElement('p');
                                    p_status.classList.add('username');
                                    p_status.appendChild(document.createTextNode("Status du tikets :"));
                                    p_status.appendChild(document.createElement('br'));
                                    p_status.appendChild(document.createTextNode(ticket.status));
                                    document.body.appendChild(p_status);
                                    href_tickets.appendChild(p_status);

                                    let p_created_at = document.createElement('p');
                                    p_created_at.classList.add('username');
                                    p_created_at.appendChild(document.createTextNode("Créer le :"));
                                    p_created_at.appendChild(document.createElement('br'));
                                    p_created_at.appendChild(document.createTextNode(ticket.created_at));
                                    document.body.appendChild(p_created_at);
                                    href_tickets.appendChild(p_created_at);

                                    let p_updated_at = document.createElement('p');
                                    p_updated_at.classList.add('username');
                                    p_updated_at.appendChild(document.createTextNode("Update le :"));
                                    p_updated_at.appendChild(document.createElement('br'));
                                    p_updated_at.appendChild(document.createTextNode(ticket.updated_at));
                                    document.body.appendChild(p_updated_at);
                                    href_tickets.appendChild(p_updated_at);
                                    //buttonText.textContent = 'Subscribe';
                                    //buttonDiv.setAttribute('style', `margin: 0px 0px -35px 0px;`);

                                });
                            })
                            .catch(error => {
                                console.error('Erreur lors de la récupération des tickets:', error);
                            });
                    }

                    ticketguery();
                </script>
            </div>
        </div>
    </main>
    <script src="./../public/js/searchbar.js"></script>
    <script src="./../public/js/darkmode.js"></script>

</body>

</html>
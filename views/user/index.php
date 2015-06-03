<h3>&#9776; USER LIST</h3>
<table class="table">
    <thead>
        <tr>
            <th>User</th>
            <th>Name</th>
            <th>Surname</th>
            <th>E-mail</th>
            <th></th>
            <th></th>
        </tr>
    </thead>
    <tbody>
        <?php foreach($list as $user) { ?>
            <tr>
                <td><a href="?controller=user&action=show&id=<?php echo $user->id(); ?>"><?php echo $user->username(); ?></a></td>
                <td><?php echo $user->name(); ?></td>
                <td><?php echo $user->surname(); ?></td>
                <td><?php echo $user->email(); ?></td>
                <td><a href="?controller=user&action=manage&id=<?php echo $user->id(); ?>">&#9998;</a></td>
                <td><a href="?controller=user&action=drop&id=<?php echo $user->id(); ?>">&#10008;</a></td>
            </tr>
        <?php } ?>
    </tbody>
</table>
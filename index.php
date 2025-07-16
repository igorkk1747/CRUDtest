<?php
$users = json_decode(file_get_contents('users.json'), true);

if (isset($_POST['action'])) {
    if ($_POST['action'] === 'add') {
        $users[] = [
            'id' => time(),
            'name' => $_POST['name'],
            'email' => $_POST['email']
        ];
    }

    if ($_POST['action'] === 'delete') {
        $id = $_POST['id'];
        $users = array_filter($users, function($u) use ($id) {
            return $u['id'] != $id;
        });
    }

    if ($_POST['action'] === 'edit') {
        foreach ($users as &$user) {
            if ($user['id'] == $_POST['id']) {
                $user['name'] = $_POST['name'];
                $user['email'] = $_POST['email'];
            }
        }
    }

    file_put_contents('users.json', json_encode(array_values($users), JSON_PRETTY_PRINT));
    header("Location: index.php");
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title></title>
</head>
<body>
    <h2> </h2>
    <form method="POST">
        <input name="name" placeholder="" required>
        <input name="email" placeholder="Email" required>
        <input type="hidden" name="action" value="add">
        <button></button>
    </form>

    <h2> </h2>
    <table border="1" cellpadding="5">
        <tr>
		<th></th><th>Email</th><th></th></tr>
        <?php foreach ($users as $user): ?>
            <tr>
                <form method="POST">
                    <td><input name="name" value="<?= $user['name'] ?>"></td>
                    <td><input name="email" value="<?= $user['email'] ?>"></td>
                    <td>
                        <input type="hidden" name="id" value="<?= $user['id'] ?>">
                        <button name="action" value="edit"></button>
                        <button name="action" value="delete" onclick="return confirm('?')"></button>
                    </td>
                </form>
            </tr>
        <?php endforeach; ?>
    </table>
</body>
</html>
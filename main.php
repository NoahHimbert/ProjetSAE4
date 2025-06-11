<?php
$fichier = "donnees.csv";

if (isset($_POST['reset'])) {
    file_put_contents($fichier, "");
    $message = "🗑️ Données supprimées avec succès.";
} elseif ($_SERVER["REQUEST_METHOD"] == "POST") {
    $capteur = $_POST['capteur'] ?? '';
    $donnee = $_POST['donnee'] ?? '';
    if ($capteur !== '' && $donnee !== '') {
        $ligne = "$capteur,$donnee," . date("Y-m-d H:i:s") . "\n";
        file_put_contents($fichier, $ligne, FILE_APPEND);
        $message = "✅ Donnée enregistrée : $capteur / $donnee";
    } else {
        $message = "⚠️ Tous les champs doivent être remplis.";
    }
}

$donnees = file_exists($fichier) ? file($fichier) : [];

$filtre = $_GET['filtre'] ?? '';
if ($filtre !== '') {
    $donnees = array_filter($donnees, function($ligne) use ($filtre) {
        return str_starts_with($ligne, $filtre . ",");
    });
}

if (isset($_GET['export'])) {
    header("Content-Type: text/csv");
    header("Content-Disposition: attachment; filename=export_donnees.csv");
    echo "Capteur,Donnée,Date\n";
    foreach ($donnees as $ligne) {
        echo $ligne;
    }
    exit;
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <title>Domomix - Capteurs</title>
  <style>
    body { font-family: Arial, sans-serif; max-width: 800px; margin: auto; background: #f8f9fa; padding: 20px; }
    h2 { border-bottom: 1px solid #ccc; padding-bottom: 5px; }
    form, .tools { background: #fff; padding: 15px; border: 1px solid #ddd; border-radius: 8px; margin-bottom: 20px; }
    label { display: block; margin-top: 10px; }
    input[type=text] { width: 100%; padding: 5px; margin-top: 5px; box-sizing: border-box; }
    button, .tools a { margin-top: 10px; padding: 10px 15px; background: #007bff; color: white; border: none; cursor: pointer; border-radius: 5px; text-decoration: none; display: inline-block; }
    button:hover, .tools a:hover { background: #0056b3; }
    table { width: 100%; border-collapse: collapse; background: #ffffff; }
    th, td { border: 1px solid #ccc; padding: 8px; text-align: center; }
    tr:nth-child(even) { background: #f2f2f2; }
    .message { font-weight: bold; margin-bottom: 10px; }
    .tools { display: flex; justify-content: space-between; flex-wrap: wrap; gap: 10px; }
  </style>
</head>
<body>
  <h2>Ajouter une donnée capteur</h2>
  <form method="POST">
    <label>ID Capteur :</label>
    <input type="text" name="capteur" required>
    <label>Valeur :</label>
    <input type="text" name="donnee" required>
    <button type="submit">Envoyer</button>
  </form>

  <?php if (isset($message)) echo "<div class='message'>$message</div>"; ?>

  <div class="tools">
    <form method="POST" style="margin: 0;">
      <button type="submit" name="reset">🗑️ Vider les données</button>
    </form>
    <form method="GET" style="margin: 0;">
      <input type="text" name="filtre" placeholder="Filtrer par capteur" value="<?= htmlspecialchars($filtre) ?>">
      <button type="submit">Filtrer</button>
    </form>
    <a href="?export=1">⬇️ Exporter en CSV</a>
  </div>

  <h2>Historique des données</h2>
  <table>
    <tr><th>Capteur</th><th>Donnée</th><th>Date</th></tr>
    <?php foreach ($donnees as $ligne): 
      $cols = explode(",", trim($ligne)); ?>
      <tr>
        <td><?= htmlspecialchars($cols[0]) ?></td>
        <td><?= htmlspecialchars($cols[1]) ?></td>
        <td><?= htmlspecialchars($cols[2]) ?></td>
      </tr>
    <?php endforeach; ?>
  </table>
</body>
</html>

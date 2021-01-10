<h1 class="my-4">Bienvenu au page des annoces</h1>
<a href="/annonces/add" > <button class="btn btn-primary"> ajouter une annonce </button></a>

<table class="table my-3">
    <thead class="thead-light">
        <tr>
            <th scope="col" style="width: 5%;">#</th>
            <th scope="col" style="width: 20%;">titre d'annonce</th>
            <th scope="col" style="width: 50%;">description</th>
            <th scope="col" style="width: 15%;">created at</th>
        </tr>
    </thead>
    <tbody>    
    <?php foreach ($annonces as $annonce):?>
        <tr>
            <td><?=$annonce->id?></td>
            <td><a href="/annonces/annonce/<?=$annonce->id?>"> <?=$annonce->titre?> </a></td>
            <td class="ml-3"> <?=$annonce->description   ?> </td>
            <td class="ml-3"> <?=$annonce->created_at   ?> </td>
        </tr>
    <?php endforeach ?>
    </tbody>
</table>
    
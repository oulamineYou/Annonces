<h1 class="my-4">Bienvenu au page des annoces</h1>

<table class="table my-3">
    <thead class="thead-light">
        <tr>
            <th scope="col" style="width: 5%;">#</th>
            <th scope="col" style="width: 20%;">titre d'annonce</th>
            <th scope="col" style="width: 30%;">description</th>
            <th scope="col" style="width: 7%;">actif</th>
            <th scope="col" style="width: 18%;">created at</th>
            <th scope="col" style="width: 20%;">actions</th>
        </tr>
    </thead>
    <tbody>    
    <?php foreach ($annonceArray as $annonce):?>
        <tr>
            <td><?=$annonce->id?></td>
            <td><a href="/annonces/annonce/<?=$annonce->id?>"> <?=$annonce->titre?> </a></td>
            <td class="ml-3"> <?=$annonce->description   ?> </td>
            <td class="ml-3"> 
                <div class="custom-control custom-switch">
                    <input type="checkbox" class="custom-control-input" id="customSwitch<?=$annonce->id?>" <?= ($annonce->actif) ?'checked': '' ?> data-id="<?=$annonce->id?>">
                    <label class="custom-control-label" for="customSwitch<?=$annonce->id?>"></label>
                </div>
            </td>
            <td class="ml-3"> <?=$annonce->created_at   ?> </td>
            <td class="ml-3"> <a href="/annonces/update/<?=$annonce->id?>" class="btn btn-warning mx-2"> update </a> <a href="#" class="btn btn-danger mx-2" onclick="deleteConfirme(<?=$annonce->id?>)"> delete </a> </td>
        </tr>
    <?php endforeach ?>
    </tbody>
</table>
    
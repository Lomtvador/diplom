<div class="categoriesWrap">
    <form>
        <label for="category">Выберите категорию</label>
        <select name="category" id="category">
            <option>Все</option>
            <optgroup label="Комиксы">
                <?php foreach ($comics as $option) { ?>
                    <option><?= $option ?></option>
                <?php } ?>
            </optgroup>
            <optgroup label="Журналы">
                <?php foreach ($magazines as $option) { ?>
                    <option><?= $option ?></option>
                <?php } ?>
            </optgroup>
        </select>
        <input type="submit" value="Выбрать">
    </form>
</div>
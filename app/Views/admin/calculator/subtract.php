<style>
    .text-success{
        font-size: xx-large;
        font-weight: 700;
    }
</style>

<div class="container col-md-3 col-md-offset-4 weli">
    <h2>Addition</h2>
    <h3><?php echo (isset($formula)) ? $formula : "Formula Calculator"; ?></h3>
            <form action="admin/calculator/subtract" method="post">
                <div class="form-group">
                    <label for="num1">Enter Number:</label>
                    <input type="number" class="form-control" id="num1" placeholder="Enter Number" name="num1" />
                </div>
                <div class="form-group">
                    <label for="num2">Enter Number:</label>
                    <input type="number" class="form-control" id="num2" placeholder="Enter Number" name="num2" />
                </div>
                <div class="form-group">
                    <label for="ans">Answer</label>
                    <p class="text-success"><?= $ans; ?></p>
                </div>
                <input type="text" name="num1">
                <input type="text" name="num2">
                <input type="text" name="num3">
                <input type="submit" name="subtract" value="calc">
                <button type="submit" class="btn btn-default" name="subtract">Submit</button>
            </form>    
</div>
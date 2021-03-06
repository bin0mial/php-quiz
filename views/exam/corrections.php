<div class="container mt-sm-5 my-1">
    <div class="question ml-sm-5 pl-sm-5 pt-2">
        <div class="d-flex justify-content-between">
            <h1 class="py-2 h1">Correction</h1>
            <div class="py-2 h4">
                <span>Score: </span>
                <span class="<?php echo $correction["score"] === $correction["total_score"] ? "text-success" : "text-danger" ?>"><?php echo $correction["score"] ?></span>
                <span>/<?php echo $correction["total_score"] ?></span>
            </div>
        </div>
        <?php $counter=1 ?>
        <div class="ml-md-3 ml-sm-3 pl-md-5 pt-sm-0 pt-3" id="options">
            <?php foreach ($correction["questions"] as $question) { ?>
                <div class="py-2 h5"><?php echo $question->get_question() ?></div>
                <?php foreach ($question->get_options() as $option) { ?>
                    <?php $chosen = isset($_SESSION[USER_ANSWERS_PREFIX.$counter]) && $option === trim($_SESSION[USER_ANSWERS_PREFIX.$counter]) ?>
                    <div class="options rounded <?php echo $option===$question->get_answer()?"bg-success": ($chosen?"bg-danger":"")?>">
                        <label for="id<?php echo $counter?>"><?php echo $option; ?></label>
                        <input id="id<?php echo $counter?>" type="radio" <?php echo $chosen?"checked":"" ?> disabled> <span class="checkmark"></span>
                    </div>
                <?php } ?>
                <?php $counter++ ?>
            <?php } ?>
        </div>
    </div>
</div>
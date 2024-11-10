<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var app\models\Offers $model */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Offers', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);

// Определяем URL для перенаправления после удаления
$deleteUrl = Url::to(['offers1/delete']);
$indexUrl = Url::to(['offers1/index']);

?>
<div class="offers-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::button('Удалить', [
            'class' => 'btn btn-danger',
            'id' => 'delete-offer-button',
            'data-id' => $model->id,
        ]) ?>
        <?= Html::a('Назад к списку офферов', ['index'], ['class' => 'btn btn-primary']) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'name',
            'email:email',
            'phone',
            'created_at',
        ],
    ]) ?>

</div>

<?php

$script = <<<JS
$('#delete-offer-button').on('click', function() {
    var id = $(this).data('id');
    if (confirm('Вы уверены, что хотите удалить этот оффер?')) {
        $.ajax({
            url: '{$deleteUrl}',
            type: 'POST',
            data: {id: id, _csrf: yii.getCsrfToken()},
            success: function(response) {
                if (response.status === 'success') {
                    alert('Оффер успешно удалён.');
                    window.location.href = '{$indexUrl}';
                } else {
                    alert('Ошибка при удалении оффера: ' + response.message);
                }
            },
            error: function() {
                alert('Ошибка при выполнении запроса.');
            }
        });
    }
});
JS;
$this->registerJs($script);
?>

<?php

use yii\helpers\Html;
use yii\helpers\Url;
use Taskforce\Tasks;
use app\models\Response;
use app\models\Review;
use kartik\rating\StarRating;

$this->registerJsFile('/js/rating.js');

?>

<div class="response-card">
    <img class="customer-photo" src="<?= Html::encode($model->user->avatar); ?>" 
    width="146" height="156" alt="Фото заказчика">
        <div class="feedback-wrapper">
            <a href="<?= Url::to(['/user/view', 'id' => $model->user_id]); ?>" 
            class="link link--block link--big"><?= Html::encode($model->user->name) ?></a>
            <div class="response-wrapper">
                <?php echo StarRating::widget([
                'name' => 'stars-rating-small',
                'value' => $model->user->stats,
                'pluginOptions' => [
                'filledStar' => '<img src="/img/star-fill.svg"></img>',
                'emptyStar' => '<img src="/img/star-empty.svg"></img>',
                'step' => 0.1,
                'size' => 'xs',
                'readonly' => true,
                'showClear' => false,
                'showCaption' => false,
                'display' => 'none'
                ],
            ]); ?>
            <p class="reviews"><?= Html::encode($reviewsCount); ?> отзыва</p>
            </div>
            <p class="response-message">
                <?= Html::encode($model->comment); ?>
            </p>
        </div>
        <div class="feedback-wrapper">
            <p class="info-text"><span class="current-time">
                <?= Yii::$app->formatter->asRelativeTime($model->creation); ?></p>
            <p class="price price--small"><?= Html::encode($model->price); ?> ₽</p>
        </div>
            <?php if (
            Yii::$app->user->getId() === $model->task->user_id &&
             $model->task->status === Tasks::STATUS_NEW && $model->position === Response::POSITION_CONSIDERED
) :
                                                ?>
        <div class="button-popup">
            <a href="<?= Url::to(['tasks/accept', 'id' => $model->id]); ?>" 
            class="button button--blue button--small">Принять</a>
            <a href="<?= Url::to(['tasks/refuse', 'id' => $model->id]); ?>"
            class="button button--orange button--small">Отказать</a>
        </div>
            <?php endif; ?>
</div>

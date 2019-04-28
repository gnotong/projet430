<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>
        Panneau de gestion
    </h1>
  </section>

  <section class="content">
    <div class="row">
      <div class="col-lg-3 col-xs-6">
        <!-- small box -->
        <div class="small-box bg-aqua">
          <div class="inner">
            <h3>
              <?php if(isset($resourcesCount)) { echo $resourcesCount; } else { echo '0'; } ?>
            </h3>
            <p>Ressources</p>
          </div>
          <div class="icon">
            <i class="fa fa-tasks"></i>
          </div>
          <a href="<?php echo base_url(); ?><?php  if($role != ROLE_EMPLOYEE) {echo 'resources';}else{echo 'eresouce';} ?>" class="small-box-footer">Plus d'informations
            <i class="fa fa-arrow-circle-right"></i>
          </a>
        </div>
      </div>
      <!-- ./col -->
      <div class="col-lg-3 col-xs-6">
        <!-- small box -->
        <div class="small-box bg-green">
          <div class="inner">
            <h3>
              <?php if(isset($finishedResourcesCount)) { echo $finishedResourcesCount; } else { echo '0'; } ?>
            </h3>
            <p>Ressources terminées</p>
          </div>
          <div class="icon">
            <i class="ion ion-pie-graph"></i>
          </div>
          <a href="<?php echo base_url(); ?><?php  if($role != ROLE_EMPLOYEE) {echo 'resources';}else{echo 'eresouce';} ?>" class="small-box-footer">Plus d'informations
            <i class="fa fa-arrow-circle-right"></i>
          </a>
        </div>
      </div>
      <!-- ./col -->
      <div class="col-lg-3 col-xs-6">
        <!-- small box -->
        <div class="small-box bg-yellow">
          <div class="inner">
            <h3>
              <?php if(isset($usersCount)) { echo $usersCount; } else { echo '0'; } ?>
            </h3>
            <p>Utilisateurs</p>
          </div>
          <div class="icon">
            <i class="ion ion-person"></i>
          </div>
          <a href="<?php echo base_url(); ?>user_list" class="small-box-footer">Plus d'informations
            <i class="fa fa-arrow-circle-right"></i>
          </a>
        </div>
      </div>
      <!-- ./col -->
      <div class="col-lg-3 col-xs-6">
        <!-- small box -->
        <div class="small-box bg-red">
          <div class="inner">
            <h3>
              <?php if(isset($logsCount)) { echo $logsCount; } else { echo '0'; } ?>
            </h3>
            <p>Log</p>
          </div>
          <div class="icon">
            <i class="fa fa-archive"></i>
          </div>
          <a href="<?php echo base_url(); ?>log-history" class="small-box-footer">Plus d'informations
            <i class="fa fa-arrow-circle-right"></i>
          </a>
        </div>
      </div>
      <!-- ./col -->
    </div>
  </section>
</div>
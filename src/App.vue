<template>
  <div class="vue-template">
    <!-- Navigation -->
    <nav class="navbar shadow bg-white rounded justify-content-between flex-nowrap flex-row fixed-top">
      <div class="container">
        <img src="https://its.alliedglobalbpo.com/static/media/logoallied.b8ec141f.png" alt="Allied Global, logo" height="50px">
        <ul class="nav navbar-nav flex-row float-right">
          <li class="nav-item">
            <router-link class="nav-link pr-3" to="/">Ingresar Datos</router-link>
          </li>
          <li class="nav-item">
            <router-link class="btn btn-outline-primary" to="/login">Login</router-link>
          </li>
        </ul>
      </div>
    </nav>

    <!-- Main -->
    <div class="App">
      <div class="vertical-center">
        <div class="inner-block">
          <router-view />
        </div>
      </div>
    </div>
  </div>
</template>
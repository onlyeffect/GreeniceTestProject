<template>
  <div>
    <div>
      <h1>Search and add a place:</h1>
      <div v-if="addedPlace" class="alert alert-success">{{addedPlace}} added successfully</div>
      <div v-if="error" class="alert alert-danger">Something went wrong</div>
      <div class="input-group">
        <gmap-autocomplete
          @place_changed="setPlace"
          class="form-control">
        </gmap-autocomplete>
        <span class="input-group-btn">
          <button @click="addMarker" class="btn btn-md btn-primary">Search</button>
          <button @click="savePlace" class="btn btn-md btn-success">Create</button>
        </span>
      </div>
      <br/>
    </div>
    <br>
    <gmap-map
      :center="center"
      :zoom="8"
      style="width:100%;  height: 400px;"
    >
      <gmap-marker
        v-if="marker"
        :position="marker.position"
        @click="center=marker.position"
      ></gmap-marker>
    </gmap-map>
  </div>
</template>

<script>
export default {
  name: "GoogleMap",
  data() {
    return {
      center: { lat: 44.61665, lng: 33.5253671 },
      marker: null,
      place: null,
      currentPlace: null,
      addedPlace: null,
      error: null
    };
  },
  methods: {
    setPlace(place) {
      this.currentPlace = place;
    },
    addMarker() {
      if (this.currentPlace) {
        const marker = {
          lat: this.currentPlace.geometry.location.lat(),
          lng: this.currentPlace.geometry.location.lng()
        };
        this.marker = { position: marker };
        this.place = this.currentPlace;
        this.center = marker;
        this.currentPlace = null;
      }
    },
    savePlace() {
      if(this.place !== null){
        let address = '';
        this.place.address_components.forEach(function(item){
          address += item.long_name + ' ';
        });
        if(address !== null){
          axios({
            method: 'post',
            url: '/places', 
            data: {
              address: address,
              lat: this.place.geometry.location.lat(),
              lng: this.place.geometry.location.lng()
            }
          }).then((response) => {
            this.addedPlace = response.data;
          })
          .catch((error) => {
            this.addedPlace = false;
            this.error = true;
            console.log(error);
          });
        }
      } else {
        console.log('No place selected!');
      }
    }
  }
};
</script>
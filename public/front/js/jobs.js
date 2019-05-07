$(function () {
    $('.view-calendar').click(function(){
        $('#calendar-frame').attr('src', 'https://calendar.google.com/calendar/embed?src=tasagentsaaa@gmail.com')
        $('.schedule-modal').modal()
    })
    $('.do-train').click(function(){
        var re = checkingJob();
        if(re['res'] == 0){
            notAvailable()
        }else if(re['res'] == -1){
            notLogined()
        }else if(re['res'] == -2){
            notVerified()
        }else if(re['res'] == 'ok' || re['res'] == -3){
            location.href = BASE_URL + '/jobs/traning?j=' + $('.card').attr('iid')
        }
    })
    
    $('.job').click(function () {
        if ($('#jobs > .container').length) {

            $('.job-list')
                    .parent().attr('class', 'col-sm-6');

            $('#jobs > .container')
                    .attr('class', 'container-fluid');

            $('.job-detail-view')
                    .parent()
                    .removeClass('hide');

        }

        $('.job').removeClass('active');

        $(this).addClass('active');

        $('.card').attr('iid', $(this).attr('iid'))
alert()
        var referOffset = $(this).offset();
        var iid = $(this).attr('iid')
        $.get(BASE_URL + '/jobs?id=' + iid + '&_='+Date.now(), function (r) {
            
            $('.job-title').html(r.name)
            $('.job-detail-content').html(r.description)
            $('.job-date').text('Posted at ' + r.created_at)
            $('.mailto-employer').attr('href', 'mailto:' + r['poster']['email'])

            if (r['myapplication']) {
                $('.do-apply').hide()
                $('.view-apply,.view-calendar').show()
                $('.job-date').text('Applied at ' + r['myapplication'].created_at.substr(0,10))
            }else{
                $('.do-apply').show()
                $('.view-apply,.view-calendar').hide()
            }

            var diff = referOffset.top
                    + $('.card').height()
                    - $('.job-detail-view').height()
                    - 150;
            var offsetDiff = referOffset.top - $('.job-detail-view').offset().top
            $('.card').offset({top: referOffset.top - (diff < 0 ? 0 : diff) + (Math.abs(offsetDiff) < 10 ? 10 : 0)})
        }, 'json')
    })
    
    $('.view-apply').click(function(){
        location.href = BASE_URL + '/jobs/applyresult?j=' + $('.card').attr('iid');
    })
    
    $('.do-apply').click(function () {
        var re = checkingJob();
        if(re['res'] == 0){
            notAvailable()
        }else if(re['res'] == -1){
            notLogined()
        }else if(re['res'] == -2){
            notVerified()
        }else if (re['res'] == -3) {//no personal information
            $('.personal-modal').modal();
        }else if(re['res'] == 'ok'){
            location.href = BASE_URL + '/jobs/apply?j=' + $('.card').attr('iid')
        }
    })
    
//    $('.date_start-datepicker').datepicker({
//        uiLibrary: 'bootstrap4'
//    });
    
    function checkingJob(){
        var re = false;
        $.ajax({
            async: false,
            dataType: 'json',
            url: BASE_URL + '/jobs?checking_apply=' + $('.card').attr('iid'),
            success: function (r) {
                re = r;
            }
        })
        
        return re;
    }
    
    function notAvailable(){
        Swal.fire('This job not available for now' ,'',  'warning')
    }
    
    function notLogined(){
        Swal.fire({
            title: 'Not logined yet. Login please..',
            text: "",
            type: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Login'
        }).then((result) => {
            if (result.value) {
                setTimeout(function () {
                    location.href = BASE_URL + '/login'
                }, 500)
            }
        })
    }
    
    function notVerified(){
        Swal.fire({
            title: 'Not verified your email yet.',
            text: "",
            type: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Sending verify code'
        }).then((result) => {
            if (result.value) {
                setTimeout(function () {
                    location.href = BASE_URL + '/email/verify';
                }, 500)
            }
        })
    }
})
Vue.component('Datepcker_date_start', {
  template: '<input type="text" class="form-control date_start-datepicker">',
  mounted: function() {
    $(this.$el).datepicker();
  },
  beforeDestroy: function() {
    $(this.$el).datepicker('hide').datepicker('destroy');
  }
});

Vue.component('Datepcker_personal_entered', {
  template: '<input type="text" class="form-control personal_entered-datepicker">',
  mounted: function() {
    $(this.$el).datepicker();
  },
  beforeDestroy: function() {
    $(this.$el).datepicker('hide').datepicker('destroy');
  }
});

Vue.component('Datepcker_personal_entered', {
  template: '<input type="text" class="form-control personal_entered-datepicker">',
  mounted: function() {
    $(this.$el).datepicker();
  },
  beforeDestroy: function() {
    $(this.$el).datepicker('hide').datepicker('destroy');
  }
});

Vue.component('Datepcker_personal_discharge', {
  template: '<input type="text" class="form-control personal_discharge-datepicker">',
  mounted: function() {
    $(this.$el).datepicker();
  },
  beforeDestroy: function() {
    $(this.$el).datepicker('hide').datepicker('destroy');
  }
});

new Vue({
    el: "#apply_online",
    data: {
        personal: {phone: '', email: '', password: '', password_confirm: ''},
        offerinfo: {
            adc: {signature: '', date: '', contact_number: ''},
            main:{
                firstname:'',middlename:'',lastname:'',
                date:'',ssn:'',
                present_address:'',apt:'',city:'',state:'',zipcode:'',
                telephone_no:'',howlong_addr:'',
                age18:0,detail_age:'',
                position_for:'',is_fulltime:0,
                date_start:'',is_parttime:0,
                arrested:0,crime:0,
                crime_detail:'',
                driver_license:1,
                transportation:'',
                driver_licence_number:'',state_of_issue:'',expiration_date:'',
                accident_violation:0,
                accident_violation_count:'',

            },
            background:[],
            
            personal_specified:{armed_force:0,national_guard:1,speciality:'',enterdate:'',dischargedate:''},
            
            notes:[],
            contactable_to_employer:true,
            completed_self:true,
            completed_who:'',
            addition_info:''
        }
    },

    methods: {
        removeNote(nind){
            this.offerinfo.notes.splice(nind,1)
        },
        addNewNote(){
            this.offerinfo.notes.push({
                empname:'',supervisor:'',
                fulladdress:'',emp_start_end:'',
                city:'',state:'',zipcode:'',pay_salary:'',
                phone_no:'',lastjob:'',reason_leaving:'',
                lastjob_detail:''
            })
        },
        addNewBackground (){
            this.offerinfo.background.push({degree:'',school:'',location:'',years:'',major:''})
        },
        doRegister(){
            this.offerinfo.main.date_start = $('.date_start-datepicker').val();
            this.offerinfo.personal_specified.enterdate = $('.personal_entered-datepicker').val();
            this.offerinfo.personal_specified.dischargedate = $('.personal_discharge-datepicker').val();
            
            var formData = new FormData();
            if($('#resume-file').val()){
                var file = $('#resume-file').get(0).files[0];
                formData.append('resumeFile', file);
            }
            
            formData.append('_token', $('input[name=_token]').val());
            formData.append('offerinfo', JSON.stringify(this.offerinfo));

            var request = new XMLHttpRequest();
            request.onreadystatechange = function () {
                if (request.readyState == 4 && request.status == 200) {
                    Swal.fire(
                        'Saved successfully!',
                        "",
                        'success'
                    ).then((result) => {
                        $('.personal-modal').modal('hide');
                    })
                }
            };
            request.open('POST', BASE_URL + '/jobs/offerinfo');
            request.send(formData);
            return true;
        },
    }
});

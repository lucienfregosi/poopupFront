var gulp = require('gulp');
var sass = require('gulp-sass');
var concat = require('gulp-concat');

gulp.task('sass', function () {
  gulp.src(['scss/_variables.scss',
            'scss/_typography.scss',
            'scss/_global.scss',
            'scss/_account.scss',
            'scss/_header.scss',
            'scss/_footer.scss',
            'scss/_footer.scss'
          ])
      .pipe(concat('main.scss'))
      .pipe(gulp.dest('scss'));

  return gulp.src(['scss/main.scss'])
    .pipe(sass())
    .on('error', function(error) {
      console.log(error);
    })
    .pipe(gulp.dest('css'));
});

gulp.task('sass:watch', function () {
  gulp.watch('scss/**/*.scss', ['sass']);
});

gulp.task('default', ['sass:watch']);

// Import the dependencies to the project
const gulp = require('gulp');
const sass = require('gulp-sass');
const del = require('del');

// Setup the task to turn scss into css
gulp.task('sass', () => {
  return gulp
    .src('./sass/main.scss')
    .pipe(sass().on('error', sass.logError))
    .pipe(gulp.dest('./public/assets/styles'));
});

// Delete everything in the css file before writing new
gulp.task('del', () => {
  return del(['./public/assets/styles/main.css']);
});

// Setup the task to monetoring changes in sas files
// And clear the main.css before writing it again
gulp.task('watch', () => {
  gulp.watch('./sass/**/*.scss', gulp.series('del')),
    gulp.watch('./sass/**/*.scss', gulp.series('sass'));
  return;
});

// Set the script up to run when the gulp command is entered
gulp.task('default', gulp.series('del', 'sass', 'watch'));
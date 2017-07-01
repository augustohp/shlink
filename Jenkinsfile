pipeline {
  agent any
  stages {
    stage('Build') {
      steps {
        sh '''composer install --no-interaction
mkdir build
composer check'''
      }
    }
  }
}
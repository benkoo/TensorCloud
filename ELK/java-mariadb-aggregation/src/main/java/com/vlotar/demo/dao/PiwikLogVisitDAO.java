package com.vlotar.demo.dao;

import com.vlotar.demo.domain.PiwikLogVisit;
import org.springframework.data.repository.CrudRepository;
import org.springframework.stereotype.Repository;

@Repository
public interface PiwikLogVisitDAO extends CrudRepository<PiwikLogVisit,Long> {
}
